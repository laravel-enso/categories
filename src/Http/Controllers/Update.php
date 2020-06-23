<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateUpdateRequest;
use LaravelEnso\Categories\Models\Category;

class Update extends Controller
{
    public function __invoke(ValidateUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
    }
}
