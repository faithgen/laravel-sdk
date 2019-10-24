<?php

namespace FaithGen\SDK\Http\Requests\Ministry;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current' => 'required|string|min:6',
            '_new' => 'required|string|min:6',
            'confirm' => 'required|string|min:6',
        ];
    }
}
