<?php

namespace LaravelEnso\Categories\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\App\Models\Category;

class ValidateUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $exists = Category::whereName($this->get('name'))
                ->whereParentId($this->route('category')->parent_id)
                ->where('id', '<>', $this->route('category')->id)
                ->exists();

            if ($exists) {
                $validator->errors()
                    ->add('name', 'duplicate');
            }
        });
    }
}
