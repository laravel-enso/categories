<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Forms\Builders\Category;

class Create extends Controller
{
    public function __invoke(Category $form)
    {
        return ['form' => $form->create()];
    }
}
