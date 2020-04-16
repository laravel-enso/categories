<?php

use Faker\Generator as Faker;
use LaravelEnso\Categories\App\Models\Category;

$factory->define(Category::class, fn (Faker $faker) => [
    'parent_id' => null,
    'name' => $faker->unique()->word,
]);
