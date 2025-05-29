<?php

namespace LaravelEnso\Categories\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;
use LaravelEnso\Files\Http\Resources\Url;

class Category extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'orderIndex' => $this->order_index,
            'isFeatured' => $this->is_featured,
            'selected' => false,
            'items' => self::collection($this->subcategories()),
            'image' => new Url($this->whenLoaded('image')),
        ];
    }

    private function subcategories()
    {
        $subcategories = $this->relationLoaded('subcategories')
            ? $this->subcategories
            : $this->whenLoaded('recursiveSubcategories');

        return ! $subcategories || $subcategories instanceof MissingValue
            ? []
            : $subcategories;
    }
}
