<?php

namespace LaravelEnso\Categories\App\Http\Controllers;

use LaravelEnso\Categories\App\Tables\Builders\CategoryTable;
use Illuminate\Routing\Controller;
use LaravelEnso\Tables\App\Traits\Excel;

class ExportExcel extends Controller
{
    use Excel;

    protected string $tableClass = CategoryTable::class;
}
