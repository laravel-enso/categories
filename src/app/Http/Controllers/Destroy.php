<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Models\Category;
use Illuminate\Routing\Controller;

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
