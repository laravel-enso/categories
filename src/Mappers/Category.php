<?php

namespace LaravelEnso\Categories\Mappers;

use Illuminate\Support\Collection;
use LaravelEnso\Categories\Models\Category as Model;

class Category
{
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new Collection();
    }

    public function loadRecursive(): Collection
    {
        $this->load()->initParents();

        return $this->categories;
    }

    private function load(): Category
    {
        $this->categories = Model::all()
            ->mapWithKeys(fn (Model $category) => [$category->id => $category])
            ->each(fn (Model $category) => $category->setRelation('subcategories', new Collection()));

        return $this;
    }

    private function initParents(): void
    {
        $this->categories->filter->parent_id
            ->each(fn (Model $category) => $this->setParent($category));

        $this->categories = $this->categories->reject->parent_id;
    }

    private function setParent(Model $category): void
    {
        $this->categories->get($category->parent_id)
            ->subcategories->push($category);
    }
}
