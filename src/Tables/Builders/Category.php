<?php

namespace LaravelEnso\Categories\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\Tables\Contracts\Table;

class Category implements Table
{
    protected $path = __DIR__.'/../Templates/categories.json';

    public function query(): Builder
    {
        return Model::with('recursiveParent:id,parent_id,name')
            ->select(['id', 'name', 'parent_id']);
    }

    public function templatePath(): string
    {
        return $this->path;
    }
}
