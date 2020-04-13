<?php

namespace FaithGen\SDK\Http\Requests;

use FaithGen\SDK\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class SendRevealRequest extends FormRequest
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
            'review' => 'required|string',
            'type' => 'required|in:'.implode(',', Helper::$reviewTypes),
        ];
    }
}
