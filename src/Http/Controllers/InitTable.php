<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Tables\Builders\Category;
use LaravelEnso\Tables\Traits\Init;

class InitTable extends Controller
{
    use Init;

    protected string $tableClass = Category::class;
}
