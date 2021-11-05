<?php

namespace LaravelEnso\Categories\Imports\Validators;

use LaravelEnso\Categories\Models\Category;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\DataImport\Services\Validators\Validator;
use LaravelEnso\Helpers\Services\Obj;

class CategoriesImportValidator extends Validator
{

    public function run(Obj $row, DataImport $import)
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
