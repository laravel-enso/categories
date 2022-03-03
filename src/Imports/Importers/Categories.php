<?php

namespace LaravelEnso\Categories\Imports\Importers;

use LaravelEnso\Categories\Models\Category;
use LaravelEnso\DataImport\Contracts\Importable;
use LaravelEnso\DataImport\Models\Import;
use LaravelEnso\Helpers\Services\Obj;

class Categories implements Importable
{
    public function run(Obj $row, Import $import)
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
