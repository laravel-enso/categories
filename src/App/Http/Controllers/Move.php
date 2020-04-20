<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Http\Requests\ValidateReorderRequest;
use LaravelEnso\Categories\App\Models\Category;

class Move extends Controller
{
    public function __invoke(ValidateReorderRequest $request)
    {
        Category::move(
            $request->get('id'),
            $request->get('newIndex'),
            $request->get('parentId')
        );
    }
}
