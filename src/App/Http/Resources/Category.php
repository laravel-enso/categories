<?php

namespace LaravelEnso\Categories\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'orderIndex' => $this->order_index,
            'selected' => false,
            'subcategories' => self::collection($this->subcategories()),
        ];
    }

    private function subcategories()
    {
        return $this->relationLoaded('subcategories')
            ? $this->subcategories
            : $this->whenLoaded('recursiveSubcategories');
    }
}
