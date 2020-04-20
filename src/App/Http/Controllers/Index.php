<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Resources\Category as Resource;
use LaravelEnso\Categories\App\Models\Category;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(Category::tree());
    }
}
