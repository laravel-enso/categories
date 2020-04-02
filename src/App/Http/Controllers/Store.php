<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateCategoryRequest;
use LaravelEnso\Categories\App\Models\Category;

class Store extends Controller
{
    public function __invoke(ValidateCategoryRequest $request, Category $category)
    {
        $category->fill($request->validated())->save();

        return [
            'message' => __('The category was successfully created'),
            'redirect' => 'administration.categories.edit',
            'param' => ['category' => $category->id],
        ];
    }
}
