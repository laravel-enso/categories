<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Forms\Builders\CategoryForm;

class Create extends Controller
{
    public function __invoke(CategoryForm $form)
    {
        return ['form' => $form->create()];
    }
}
