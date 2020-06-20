<?php

namespace FaithGen\SDK\Http\Requests;

use FaithGen\SDK\Models\Ministry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user() instanceof Ministry) {
            $routeModel = collect($this->route()->parameters());

            $modelName = $routeModel->keys()->first();

            $binding = collect(app()->getBindings())
                ->filter(function ($binding, $key) use ($modelName) {
                    return Str::contains($key, '\\'.ucfirst($modelName)) && Str::endsWith($key, 'Service');
                })
                ->keys()
                ->first();

            $modelMethod = 'get'.ucwords($modelName);

            return $this->user()->can('view', app($binding)->$modelMethod());
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required',
        ];
    }
}
