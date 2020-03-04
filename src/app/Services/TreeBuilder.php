<?php

namespace LaravelEnso\Categories\App\Services;

use Illuminate\Support\Collection;
use LaravelEnso\Categories\App\Models\Category;

class TreeBuilder
{
    private Collection $categories;

    public function handle(): Collection
    {
        return $this->categories()->tree();
    }

    private function tree(?int $parentId = null): Collection
    {
        return $this->categories
            ->filter(fn ($category) => $category->parent_id === $parentId)
            ->reduce(fn ($tree, $category) => $tree
                ->push($this->withChildren($category)), new Collection());
    }

    private function withChildren(Category $category): Category
    {
        $category->items = $this->hasChildren($category)
            ? $this->tree($category->id)
            : null;

        $category->expanded = false;

        return $category;
    }

    private function hasChildren(Category $parent): bool
    {
        return $this->categories
            ->some(fn ($category) => $parent->id === $category->parent_id);
    }

    private function categories(): self
    {
        $this->categories = Category::all();

        return $this;
    }
}
