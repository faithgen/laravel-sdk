<?php

namespace FaithGen\SDK\Http\Requests;

use FaithGen\SDK\Models\Ministry;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
/*        if (auth()->user() instanceof Ministry) {
            return $this->user()->can('view', $albumService->getAlbum());
        }*/

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

