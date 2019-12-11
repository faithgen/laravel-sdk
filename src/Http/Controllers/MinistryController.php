<?php

namespace FaithGen\SDK\Http\Controllers;

use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Traits\FileTraits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use InnoFlash\LaraStart\Http\Helper;
use Intervention\Image\ImageManager;
use FaithGen\SDK\Services\ProfileService;
use FaithGen\SDK\Http\Requests\IndexRequest;
use FaithGen\SDK\Models\Pivots\MinistryUser;
use FaithGen\SDK\Events\Ministry\Profile\ImageSaved;
use FaithGen\SDK\Http\Requests\Ministry\DeleteRequest;
use FaithGen\SDK\Http\Requests\Ministry\Social\GetRequest;
use FaithGen\SDK\Http\Requests\Ministry\UpdateImageRequest;
use FaithGen\SDK\Http\Resources\Profile as ProfileResource;
use FaithGen\SDK\Http\Requests\Ministry\Social\UpdateRequest;
use FaithGen\SDK\Http\Requests\Ministry\UpdateProfileRequest;
use FaithGen\SDK\Http\Resources\Ministry as MinistryResource;
use FaithGen\SDK\Http\Requests\Ministry\UpdatePasswordRequest;
use FaithGen\SDK\Http\Resources\MinistryUser as ResourcesMinistryUser;
use Illuminate\Support\Facades\DB;

class MinistryController extends Controller
{
    use FileTraits;

    /**
     * @var ProfileService
     */
    private $profileService;

    /**
     * MinistryController constructor.
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    function getSocialLink(GetRequest $request)
    {
        return response()->json([
            'link' => auth()->user()->profile[$request->platform]
        ]);
    }

    function saveSocialLink(UpdateRequest $request)
    {
        $profile = auth()->user()->profile;
        $profile[$request->platform] = $request->link;
        try {
            $profile->save();
            return response()->json([
                'link' => $request->link
            ]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    function getProfile()
    {
        ProfileResource::withoutWrapping();
        MinistryResource::withoutWrapping();
        if (request()->has('complete') && request()->complete)
            return new ProfileResource(auth()->user());
        else
            return new MinistryResource(auth()->user());
    }

    function updatePhoto(UpdateImageRequest $request, ImageManager $imageManager)
    {
        if (auth()->user()->image()->exists())
            $this->deleteFiles(auth()->user());

        $fileName = str_shuffle(auth()->user()->id . time() . time()) . '.png';
        $ogSave = storage_path('app/public/profile/original/') . $fileName;
        $imageManager->make($request->image)->save($ogSave);
        $image = auth()->user()->image()->updateOrCreate([], [
            'name' => $fileName
        ]);
        event(new ImageSaved($image));
        return $this->successResponse('Photo changed, refresh page to effect changes');
    }

    function updatePassword(UpdatePasswordRequest $request)
    {
        if (Hash::check($request->current, auth()->user()->password)) {
            if (strcmp($request->_new, $request->confirm) === 0) {
                $user = auth()->user();
                $user->password = Hash::make($request->_new);
                try {
                    $user->save();
                    return $this->successResponse('Password change successful');
                } catch (\Exception $e) {
                    abort(500, $e->getMessage());
                }
            } else abort(500, 'News passwords did not match!');
        } else abort(500, 'Current password is incorrect!');
    }

    function deleteProfile(DeleteRequest $request)
    {
        if (Hash::check($request->password, auth()->user()->password)) {
            try {
                auth()->user()->delete();
                return $this->successResponse('Your profile has been deleted, it was good having you on our platform. Hope to see you again soon');
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        } else abort(500, 'Password is incorrect!');
    }

    function updateProfile(UpdateProfileRequest $request)
    {
        $ministryParams = $request->only(['name', 'email', 'phone']);
        try {
            auth()->user()->update($ministryParams);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        $links = ['website', 'facebook', 'youtube', 'twitter', 'instagram'];
        $statements = ['vision', 'mission', 'about_us'];
        $params = [];
        $params = array_merge($params, array_filter($request->links, function ($link) use ($links) {
            return in_array($link, $links);
        }, ARRAY_FILTER_USE_KEY));

        $params = array_merge($params, array_filter($request->statement, function ($link) use ($statements) {
            return in_array($link, $statements);
        }, ARRAY_FILTER_USE_KEY));

        $params = array_merge($params, [
            'emails' => $request->emails
        ]);
        $params = array_merge($params, [
            'phones' => $request->phones
        ]);
        if ($request->has('location'))
            $params = array_merge($params, [
                'location' => $request->location
            ]);
        $this->saveServices($request, auth()->user());
        return $this->profileService->update($params, 'Profile updated successfully!');
    }

    private function saveServices(Request $request, Ministry $ministry)
    {
        if ($request->has('services')) {
            DB::table('daily_services')->whereIn('id', $ministry->services()->pluck('id')->toArray())->delete();
            $services = array_map(function ($service) {
                return array_merge($service, [
                    'id' => str_shuffle((string) Uuid::generate()),
                    'ministry_id' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }, $request->services);
            $ministry->services()->insert($services);
        }
    }

    function getLinks($links)
    {
        $_links = ['website', 'facebook', 'youtube', 'twitter', 'instagram'];
        return array_key_exists($links, $_links);
    }

    function accountType()
    {
        return auth()->user()->account->level;
    }

    public function users(IndexRequest $request)
    {
        $ministryUsers = MinistryUser::whereHas('user', function ($user) use ($request) {
            return $user->where('name', 'LIKE', '%' . $request->filter_text . '%')
                ->orWhere('email', 'LIKE', '%' . $request->filter_text . '%');
        })
            //       ->with('user')
            ->latest()
            ->paginate(Helper::getLimit($request));
        return ResourcesMinistryUser::collection($ministryUsers);
    }
}
