<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Models\Category;
use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateCategoryRequest;

class Update extends Controller
{
    public function __invoke(ValidateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return ['message' => __('The category was successfully updated')];
    }
}
