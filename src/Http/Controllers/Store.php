<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateStore;
use LaravelEnso\Categories\Http\Resources\Category as Resource;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Files\Models\File;

class Store extends Controller
{
    public function __invoke(ValidateStore $request, Category $category)
    {
        $category->fill($request->validated())->save();

        $file = File::upload($category, $request->file('logo'));
        $category->file()->associate($file)->save();

        return ['item' => new Resource($category->load('subcategories'))];
    }
}
