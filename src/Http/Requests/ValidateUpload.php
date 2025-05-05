<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUpload extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ['image' => 'required|image'];
    }

    public function after($validator): array
    {
        return [fn ($validator) => $this->allowed($validator)];
    }

    private function allowed($validator): void
    {
        if ($this->route('category')->parent_id) {
            $validator->errors()
                ->add('image_id', 'Only top level categories can have images');
        }
    }
}
