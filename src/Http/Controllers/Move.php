<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateReorder;
use LaravelEnso\Categories\Models\Category;

class Move extends Controller
{
    public function __invoke(ValidateReorder $request, Category $category)
    {
        $category->move($request->get('newIndex'), $request->get('parentId'));
    }
}
