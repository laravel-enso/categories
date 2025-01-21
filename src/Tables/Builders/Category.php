<?php

namespace LaravelEnso\Categories\Tables\Builders;

use LaravelEnso\Categories\Models\Category as Model;
use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Tables\Contracts\Table;

class Category implements Table
{
    private const TemplatePath = __DIR__.'/../Templates/categories.json';

    public function query(): Builder
    {
        return Model::with('recursiveParent:id,parent_id,name')
            ->select(['id', 'name', 'parent_id', 'unspsc']);
    }

    public function templatePath(): string
    {
        return self::TemplatePath;
    }
}
