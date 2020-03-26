<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Services\TreeBuilder;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

class Options extends Controller
{
    public function __invoke()
    {
        return (new TreeBuilder())->handle();
    }
}
