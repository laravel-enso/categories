<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateUpdate;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Files\Models\File;

class Update extends Controller
{
    public function __invoke(ValidateUpdate $request, Category $category)
    {
        $category->update($request->validated());

        $file = File::upload($category, $request->file('logo'));
        $category->file()->associate($file)->save();
    }
}
