<?php

namespace App\Http\Requests\DirectMessage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDirectMessageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
