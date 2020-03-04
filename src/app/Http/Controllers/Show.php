<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Models\Category;
use Illuminate\Routing\Controller;

class Show extends Controller
{
    public function __invoke(Category $category)
    {
        return ['category' => $category];
    }
}
