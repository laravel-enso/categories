<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\App\Services\TreeBuilder;

class Options extends Controller
{
    public function __invoke()
    {
        return (new TreeBuilder())->handle();
    }
}
