<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateReorderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parentId' => 'nullable|exists:categories,id',
            'newIndex' => 'required',
        ];
    }
}
