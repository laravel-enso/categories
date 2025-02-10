<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateUpdate;
use LaravelEnso\Categories\Models\Category;

class Update extends Controller
{
    public function __invoke(ValidateUpdate $request, Category $category)
    {
        $category->fill($request->validated());
        $category->order_index ??= Category::nextIndex($request->get('parent_id'));
        $category->save();

        return ['message' => __('The category has been successfully updated')];
    }
}
