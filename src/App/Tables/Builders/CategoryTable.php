<?php

namespace LaravelEnso\Categories\App\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Categories\App\Models\Category;
use LaravelEnso\Tables\App\Contracts\Table;

class CategoryTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/categories.json';

    public function query(): Builder
    {
        return Category::selectRaw('
            categories.id, categories.name, parents.name as parentName
        ')
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id');
    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
