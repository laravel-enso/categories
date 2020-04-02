<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Models\Category;
use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateCategoryRequest;

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
