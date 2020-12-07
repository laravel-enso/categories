<?php

namespace LaravelEnso\Categories\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaravelEnso\Categories\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'parent_id' => null,
            'name' => $this->faker->unique()->word,
            'order_index' => Category::max('order_index') + 1,
        ];
    }
}
