<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateUpdateRequest;
use LaravelEnso\Categories\App\Models\Category;

class Update extends Controller
{
    public function __invoke(ValidateUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
    }
}
