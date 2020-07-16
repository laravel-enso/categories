<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Support\Facades\Config;
use LaravelEnso\Categories\Models\Category;

trait ValidateLevel
{
    protected function validateLevel($validator)
    {
        if ($this->get('parentId') !== null) {
            $newLevel = Category::find($this->get('parentId'))->level() + 1;

            if ($newLevel > Config::get('enso.categories.maxNestingLevel')) {
                $validator->after(fn($validator) => $validator->errors()
                    ->add('parentId', 'level is more than maxLevel'));
            }
        }
    }
}
