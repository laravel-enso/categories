<?php

namespace LaravelEnso\Categories\Imports\Validators;

use LaravelEnso\Categories\Models\Category;
use LaravelEnso\DataImport\Models\Import;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;

class Categories extends Validator
{
    public function run(Obj $row, Import $import)
    {
        if ($this->exists($row)) {
            $this->addError(__('category exits'));
        }
    }

    private function exists(Obj $row): bool
    {
        $name = $row->get('category');
        $parentName = $row->get('parent');

        return Category::whereName($name)
            ->whereHas('parent', fn ($parent) => $parent->whereName($parentName))
            ->exists();
    }
}
