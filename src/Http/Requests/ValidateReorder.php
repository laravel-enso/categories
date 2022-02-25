<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateReorder extends FormRequest
{
    use ValidateLevel;

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

    public function withValidator($validator)
    {
        $this->validateLevel($validator);
    }
}
