<?php

namespace LaravelEnso\Categories\Http\Controllers;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Resources\Label;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Select\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected string $resource = Label::class;

    public function query(): Builder
    {
        return Category::with('recursiveParent');
    }
}
