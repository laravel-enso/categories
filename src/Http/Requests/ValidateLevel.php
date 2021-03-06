<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Categories\Models\Category;

trait ValidateLevel
{
    protected function validateLevel($validator)
    {
        if ($this->get('parentId') !== null) {
            $currentLevel = Category::find($this->get('parentId'))->level();

            if ($currentLevel >= Config::get('enso.categories.maxNestingLevel')) {
                $validator->after(fn ($validator) => $validator->errors()
                    ->add('parentId', 'The nesting level is higher than allowed'));
            }
        }
    }
}
