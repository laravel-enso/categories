<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateLogo;
use LaravelEnso\Categories\Models\Category;

class Upload extends Controller
{
    public function __invoke(ValidateLogo $request, Category $category)
    {
        optional($category->file)->delete();

        $category->upload($request->file('logo'));

        return ['fileId' => $category->load('file')->file->id];
    }
}
