<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateStore;
use LaravelEnso\Categories\Http\Resources\Category as Resource;
use LaravelEnso\Categories\Models\Category;

class Store extends Controller
{
    public function __invoke(ValidateStore $request, Category $category)
    {
        $category->fill($request->validated());
        $category->order_index ??= Category::nextIndex($request->get('parent_id'));
        $category->save();

        return [
            'message' => __('The category was successfully created'),
            'redirect' => 'administration.categories.edit',
            'param' => ['category' => $category->id],
        ];
    }
}
