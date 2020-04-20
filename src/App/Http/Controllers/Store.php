<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateCreateRequest;
use LaravelEnso\Categories\App\Http\Resources\Category as Resource;
use LaravelEnso\Categories\App\Models\Category;

class Store extends Controller
{
    public function __invoke(ValidateCreateRequest $request, Category $category)
    {
        $category->fill($request->mapped())->save();

        return ['category' => new Resource($category->load('subcategories'))];
    }
}
