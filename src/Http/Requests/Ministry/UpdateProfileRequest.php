<?php

namespace FaithGen\SDK\Http\Requests\Ministry;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required', //todo write a regex to serve,
            'links' => 'array',
            'color' => 'required|'.Helper::$hexColorRegex,
            'location' => 'array',
            'links.*' => 'url',
            'statement' => 'array',
            'statement.*' => 'string',
            'emails' => 'array',
            'phones' => 'array',
            'emails.*' => 'email',
            'services' => 'array',
            'services.*.day' => 'required|in:'.implode(',', Helper::$weekDays),
            'services.*.start' => ['required', 'date_format:H:i', 'regex:/^((([01]?[0-9]|2[0-3]):[0-5][0-9])?)$/'],
            'services.*.finish' => ['required', 'date_format:H:i', 'regex:/^((([01]?[0-9]|2[0-3]):[0-5][0-9])?)$/'],
            'services.*.alias' => 'nullable',
        ];
    }
}
