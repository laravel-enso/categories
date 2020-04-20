<?php

namespace LaravelEnso\Categories\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\Helpers\App\Traits\MapsRequestKeys;

class ValidateCreateRequest extends FormRequest
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
        $validator->after(function ($validator) {
            $exists = Category::whereName($this->get('name'))
                ->whereParentId($this->get('parent_id'))
                ->where('id', '<>', optional($this->route('category'))->id)
                ->exists();

            if ($exists) {
                $validator->errors()
                    ->add('name', 'duplicate');
            }
        });
    }
}
