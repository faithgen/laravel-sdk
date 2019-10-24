<?php

namespace FaithGen\SDK\Http\Requests\Ministry;

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
            'location' => 'array',
            'links.*' => 'url',
            'statement' => 'array',
            'statement.*' => 'string',
            'emails' => 'array',
            'phones' => 'array',
            'emails.*' => 'email',
        ];
    }
}
