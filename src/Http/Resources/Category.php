<?php

namespace LaravelEnso\Categories\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class Category extends JsonResource
{
    public function toArray($request)
    {
        $file = $this->relationLoaded('file') && $this->file ? $this->file : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'orderIndex' => $this->order_index,
            'selected' => false,
            'subcategories' => self::collection($this->subcategories()),
            'fileId' => optional($file)->id,
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
