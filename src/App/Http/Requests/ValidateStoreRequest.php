<?php

namespace LaravelEnso\Categories\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\Helpers\App\Traits\MapsRequestKeys;

class ValidateStoreRequest extends FormRequest
{
    use MapsRequestKeys;

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
        ];
    }

    public function withValidator($validator)
    {
        if ($this->isDuplicate()) {
            $validator->after(fn ($validator) => $validator
                ->errors()->add('name', 'duplicate'));
        }
    }

    private function isDuplicate(): bool
    {
        return Category::whereName($this->get('name'))
            ->whereParentId($this->get('parentId'))
            ->where('id', '<>', optional($this->route('category'))->id)
            ->exists();
    }
}
