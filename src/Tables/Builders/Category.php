<?php

namespace LaravelEnso\Categories\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\Helpers\Services\Obj;
use LaravelEnso\Tables\Contracts\CustomFilter;
use LaravelEnso\Tables\Contracts\Table;

class Category implements Table, CustomFilter
{
    protected $path = __DIR__.'/../Templates/categories.json';

    public function query(): Builder
    {
        return Model::with('recursiveParent:id,parent_id,name')
            ->select(['id', 'name', 'parent_id', 'image_id']);
    }

    public function filterApplies(Obj $params): bool
    {
        return $params->filled('level');
    }

    public function filter(Builder $query, Obj $params)
    {
        $query->when(
            $params->filled('level'),
            fn ($query) => $this->filterLevel($query, $params)
        );
    }

    private function filterLevel($query, Obj $params): void
    {
        $query->when($params->get('level') === 1, fn ($query)=> $query->whereNull('parent_id'))
            ->when($params->get('level') === 2, fn ($query)=> $query->whereHas('recursiveParent'));
    }

    public function templatePath(): string
    {
        return $this->path;
    }
}
