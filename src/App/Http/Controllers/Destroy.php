<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Models\Category;

class Destroy extends Controller
{
    public function __invoke(Category $category)
    {
        $category->delete();

        return [
            'message' => __('The category was successfully deleted'),
            'redirect' => 'administration.categories.index',
        ];
    }
}
