<?php

namespace FaithGen\SDK\Http\Requests\Ministry;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6',
            'email' => 'required|email|unique:ministries',
            'phone' => 'required', //todo write a regex to serve
        ];
    }
}
