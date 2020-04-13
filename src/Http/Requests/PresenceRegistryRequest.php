<?php

namespace FaithGen\SDK\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class PresenceRegistryRequest extends FormRequest
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
            'item_id'=>Helper::$idValidation,
            'category'=>'required|string',
            'coming_in' => 'required|boolean',
        ];
    }
}
