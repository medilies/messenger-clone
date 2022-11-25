<?php

namespace App\Http\Requests\DirectMessage;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirectMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => ['required', 'string'],
            'target_user_id' => ['integer'],
        ];
    }
}
