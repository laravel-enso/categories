<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\Models\Category;
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
            'name' => ['required', 'max:255'],
            'orderIndex' => 'required',
            'parentId' => 'nullable|exists:categories,id',
            'logo' => 'nullable|image'
        ];
    }

    public function withValidator($validator)
    {
        if ($this->isDuplicate()) {
            $validator->after(fn ($validator) => $validator
                ->errors()->add('name', 'duplicate'));
        }

        $this->validateLevel($validator);

        if (($this->filled('parent_id') || $this->filled('levelOne')) && $this->filled('file_id')) {
            $validator->errors()
                ->add('levelOne', "You can't upload a file to a non parent");
        }
    }

    private function isDuplicate(): bool
    {
        return Category::whereName($this->get('name'))
            ->whereParentId($this->get('parentId'))
            ->where('id', '<>', $this->route('category')?->id)
            ->exists();
    }
}
