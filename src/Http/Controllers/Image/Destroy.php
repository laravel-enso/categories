<?php

namespace LaravelEnso\Categories\Http\Controllers\Image;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Models\Category;

class Destroy extends Controller
{
    public function __invoke(Category $category)
    {
        $file = $category->image;
        $category->update(['image_id' => null]);
        $file->delete();

        return ['message' => 'The image was successfully deleted'];
    }
}
