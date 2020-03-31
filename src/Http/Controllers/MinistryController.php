<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Events\Ministry\Profile\ImageSaved;
use FaithGen\SDK\Http\Requests\IndexRequest;
use FaithGen\SDK\Http\Requests\Ministry\DeleteRequest;
use FaithGen\SDK\Http\Requests\Ministry\Social\GetRequest;
use FaithGen\SDK\Http\Requests\Ministry\Social\UpdateRequest;
use FaithGen\SDK\Http\Requests\Ministry\UpdateImageRequest;
use FaithGen\SDK\Http\Requests\Ministry\UpdatePasswordRequest;
use FaithGen\SDK\Http\Requests\Ministry\UpdateProfileRequest;
use FaithGen\SDK\Http\Requests\ToggleActivityRequest;
use FaithGen\SDK\Http\Resources\Ministry as MinistryResource;
use FaithGen\SDK\Http\Resources\MinistryUser as ResourcesMinistryUser;
use FaithGen\SDK\Http\Resources\Profile as ProfileResource;
use FaithGen\SDK\Models\Ministry;
use FaithGen\SDK\Services\ProfileService;
use FaithGen\SDK\Traits\FileTraits;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use InnoFlash\LaraStart\Helper;
use InnoFlash\LaraStart\Traits\APIResponses;
use Intervention\Image\ImageManager;

class MinistryController extends Controller
{
    use FileTraits, AuthorizesRequests, APIResponses, ValidatesRequests, DispatchesJobs;

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

    /**
     * Get the social link profile.
     *
     * @param GetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getSocialLink(GetRequest $request)
    {
        return response()->json([
            'link' => auth()->user()->profile[$request->platform]
        ]);
    }

    /**
     * Saves a social link.
     *
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Get the profile of a ministry.
     *
     * @return MinistryResource|ProfileResource
     */
    function getProfile()
    {
        ProfileResource::withoutWrapping();
        MinistryResource::withoutWrapping();

        if (request()->has('complete') && request()->complete)
            return new ProfileResource(auth()->user());
        else
            return new MinistryResource(auth()->user());
    }

    /**
     * Changes the profile pic.
     *
     * @param UpdateImageRequest $request
     * @param ImageManager $imageManager
     * @return mixed
     */
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

    /**
     * Update ministry password.
     *
     * @param UpdatePasswordRequest $request
     * @return mixed
     */
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

    /**
     * Delete ministry profile.
     *
     * @param DeleteRequest $request
     * @return mixed
     */
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

    /**
     * Updates ministry profile.
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    function updateProfile(UpdateProfileRequest $request)
    {
        $ministryParams = $request->only(['name', 'email', 'phone']);

        auth()->user()->update($ministryParams);

        $links = ['website', 'facebook', 'youtube', 'twitter', 'instagram'];
        $statements = ['vision', 'mission', 'about_us'];

        $params = ['color' => $request->color];

        $params = array_merge($params, array_filter($request->links, fn($link) => in_array($link, $links), ARRAY_FILTER_USE_KEY));

        $params = array_merge($params, array_filter($request->statement, fn($link) => in_array($link, $statements), ARRAY_FILTER_USE_KEY));

        $params = array_merge($params, ['emails' => $request->emails]);

        $params = array_merge($params, ['phones' => $request->phones]);

        if ($request->has('location'))
            $params = array_merge($params, ['location' => $request->location]);

        $this->saveServices($request, auth()->user());

        return $this->profileService->update($params, 'Profile updated successfully!');
    }

    /**
     * Saves the church services.
     *
     * @param Request $request
     * @param Ministry $ministry
     */
    private function saveServices(Request $request, Ministry $ministry)
    {
        if ($request->has('services')) {
            DB::table('daily_services')
                ->whereIn('id', $ministry->services()->pluck('id')->toArray())
                ->delete();

            $services = array_map(function ($service) {
                return array_merge($service, [
                    'id' => str_shuffle((string)Str::uuid()),
                    'ministry_id' => auth()->user()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }, $request->services);
            $ministry->services()->insert($services);
        }
    }

    /**
     * Gets the links.
     *
     * @param $links
     * @return bool
     */
    function getLinks($links)
    {
        $_links = ['website', 'facebook', 'youtube', 'twitter', 'instagram'];
        return array_key_exists($links, $_links);
    }

    /**
     * Gets the account subscription level.
     *
     * @return mixed
     */
    function accountType()
    {
        return auth()->user()->account->level;
    }

    /**
     * Gets the users for a ministry.
     *
     * @param IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function users(IndexRequest $request)
    {
        $ministryUsers = auth()->user()
            ->ministryUsers()
            ->latest()
            //->with(['user.image'])
            ->where(fn($ministryUser) => $ministryUser->whereHas('user', fn($user) => $user->search(['name', 'email'], $request->filter_text)))
            ->paginate(Helper::getLimit($request));

        //return $ministryUsers;

        ResourcesMinistryUser::wrap('users');

        return ResourcesMinistryUser::collection($ministryUsers);
    }

    /**
     * Blocks or unblock a user
     *
     * @param ToggleActivityRequest $request
     * @return void
     */
    public function toggleActivity(ToggleActivityRequest $request)
    {
        $ministryUser = auth()->user()->ministryUsers()->where('user_id', $request->user_id)->first();

        if ($ministryUser) {
            $ministryUser->update($request->validated());

            return $this->successResponse('This user`s active status has been changed');
        }
        return abort(403, 'You are not allowed to alter that user, they do not belong to your following');
    }
}
