<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateUpdate;
use LaravelEnso\Categories\Models\Category;

class Update extends Controller
{
    public function __invoke(ValidateUpdate $request, Category $category)
    {
        $category->update($request->validated());

        return ['message' => __('The category has been successfully updated')];
    }
}
