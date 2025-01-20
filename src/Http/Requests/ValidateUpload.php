<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Helpers\Traits\MapsRequestKeys;

class ValidateUpload extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['logo' => 'required|image'];
    }

    public function withValidator($validator)
    {
        $category = $this->route('category');

        if (($category?->parent_id || $category->recursiveParent?->recursiveParent?->id)) {
            $validator->after(fn ($validator) => $validator->errors()
                ->add('file_id', "You can't upload a file to a non parent"));
        }
    }
}
