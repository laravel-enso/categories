<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Forms\Builders\Category as Form;
use LaravelEnso\Categories\Models\Category;

class Edit extends Controller
{
    public function __invoke(Category $category, Form $form)
    {
        return ['form' => $form->edit($category)];
    }
}
