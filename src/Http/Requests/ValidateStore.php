<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Helpers\Traits\ToSnakeCase;

class ValidateStore extends FormRequest
{
    use ToSnakeCase, ValidateLevel;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'order_index' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
            'is_featured' => 'required|boolean',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(fn ($validator) => $this->customValidations($validator));
    }

    public function customValidations($validator)
    {
        $linkedToItself = $this->filled('parent_id')
            && $this->get('parent_id') === $this->route('category')?->id
            || $this->filled('level_one')
            && $this->get('level_one') === $this->route('category')?->id;

        if ($linkedToItself) {
            $validator->errors()
                ->add('parent_id', "You can't link a category to itself");
        }
    }
}
