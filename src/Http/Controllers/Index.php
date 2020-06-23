<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Resources\Category as Resource;
use LaravelEnso\Categories\Models\Category;

class Index extends Controller
{
    public function __invoke()
    {
        return Resource::collection(Category::tree());
    }
}
