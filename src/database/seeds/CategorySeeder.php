<?php

use Illuminate\Database\Seeder;
use LaravelEnso\Categories\App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 5)->create();
    }
}
