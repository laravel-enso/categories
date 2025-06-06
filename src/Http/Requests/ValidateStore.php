<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Helpers\Traits\MapsRequestKeys;

class ValidateStore extends FormRequest
{
    use MapsRequestKeys, ValidateLevel;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'order_index' => 'nullable',
            'parent_id' => 'nullable',
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
            || $this->filled('levelOne')
            && $this->get('levelOne') === $this->route('category')?->id;

        if ($linkedToItself) {
            $validator->errors()
                ->add('parent_id', "You can't link a category to itself");
        }
    }
}
