<?php

namespace FaithGen\SDK\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route()->getName() === 'users.register') {
            return true;
        } else {
            return auth('web')->user();
        }
    }

    /**
     * Base rules for a save request.
     *
     * @var array
     */
    private $baseRules = [
        'name' => 'required|string',
        'email' => 'email',
        'phone' => 'required|string|unique:fg_users,phone',
        'image' => 'base64image',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->route()->getName() === 'users.register') {
            return $this->baseRules;
        } else {
            return array_merge($this->baseRules, [
                'phone' => 'required|string',
            ]);
        }
    }

    public function messages()
    {
        return [
            'phone.unique' => 'Number already used, try logging in instead',
        ];
    }
}
