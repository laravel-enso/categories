<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateStoreRequest;
use LaravelEnso\Categories\App\Http\Resources\Category as Resource;
use LaravelEnso\Categories\App\Models\Category;

class Store extends Controller
{
    public function __invoke(ValidateStoreRequest $request, Category $category)
    {
        $category->fill($request->validated())->save();

        return ['category' => new Resource($category->load('subcategories'))];
    }
}
