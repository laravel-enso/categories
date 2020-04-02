<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Forms\Builders\CategoryForm;
use LaravelEnso\Categories\App\Models\Category;

class Edit extends Controller
{
    public function __invoke(Category $category, CategoryForm $form)
    {
        return ['form' => $form->edit($category)];
    }
}
