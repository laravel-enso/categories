<?php

namespace LaravelEnso\Categories\Http\Controllers\Image;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Models\Category;

class Destroy extends Controller
{
    public function __invoke(Category $category)
    {
        $category->file?->delete();

        $category->update(['file_id' => null]);

        return ['message' => 'The image was successfully deleted'];
    }
}
