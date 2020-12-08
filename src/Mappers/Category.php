<?php

namespace LaravelEnso\Categories\Mappers;

use Illuminate\Support\Collection;
use LaravelEnso\Categories\Models\Category as Model;

class Category
{
    private static $instance;
    private Collection $categories;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        return static::$instance ??= new static();
    }

    public function load(): Collection
    {
        return $this->categories
            ?? $this->freshLoad();
    }

    private function freshLoad(): Collection
    {
        $this->categories = Model::all()
            ->mapWithKeys(fn (Model $category) => [$category->id => $category])
            ->each(fn (Model $category) => $category
                ->setRelation('subcategories', new Collection())
                ->setRelation('recursiveSubcategories', new Collection())
            )
        ;

        return $this->initParents();
    }

    private function initParents(): Collection
    {
        $this->categories->filter->parent_id
            ->each(fn (Model $category) => $this->setParent($category));

        return $this->categories;
    }

    private function setParent(Model $category): void
    {
        $category->setRelation('parent', $this->categories->get($category->parent_id));
        $category->setRelation('recursiveParent', $this->categories->get($category->parent_id));

        $this->categories->get($category->parent_id)
            ->subcategories->push($category);

        $this->categories->get($category->parent_id)
            ->recursiveSubcategories->push($category);
    }
}
