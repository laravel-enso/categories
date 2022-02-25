<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\Models\Category;

class ValidateUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
        ];
    }

    public function withValidator($validator)
    {
        if ($this->alreadyExists()) {
            $validator->after(function ($validator) {
                $validator->errors()->add('name', 'duplicate');
            });
        }
    }

    private function alreadyExists(): bool
    {
        return Category::whereName($this->get('name'))
            ->whereParentId($this->route('category')->parent_id)
            ->where('id', '<>', $this->route('category')->id)
            ->exists();
    }
}
