<?php

namespace LaravelEnso\Categories\App\Http\Requests;

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
            'id' => 'required|exists:categories,id',
            'parentId' => 'nullable|exists:categories,id',
            'newIndex' => 'required',
        ];
    }
}
