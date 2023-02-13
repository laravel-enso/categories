<?php

namespace LaravelEnso\Categories\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use LaravelEnso\Categories\Models\Category;

class Label extends JsonResource
{
    public function toArray($request)
    {
        $label = $this->relationLoaded('recursiveParent')
            ? $this->label($this->resource)
            : $this->name;

        return [
            'id' => $this->id,
            'name' => $label,
        ];
    }

    private function label(Category $category): string
    {
        $labels = new Collection($category->name);

        while ($category = $category->recursiveParent) {
            $labels->prepend($category->name);
        }

        return $labels->implode(' > ');
    }
}
