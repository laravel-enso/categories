<?php

namespace LaravelEnso\Categories\Imports\Importers;

use LaravelEnso\Categories\Models\Category;
use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\DataImport;
use LaravelEnso\Helpers\Services\Obj;

class CategoriesImport implements Importable
{
    public function run(Obj $row, DataImport $import)
    {
        Category::factory()->create([
            'parent_id' => $this->parentId($row),
            'name' => $row->get('category'),
        ]);
    }

    private function parentId(Obj $row): ?int
    {
        $name = $row->get('parent');

        return $name
            ? Category::whereName($name)->first()?->id
            : null;
    }
}
