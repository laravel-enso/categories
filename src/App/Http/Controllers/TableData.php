<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Tables\Builders\CategoryTable;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\App\Traits\Data;

class TableData extends Controller
{
    use Data;

    protected string $tableClass = CategoryTable::class;
}
