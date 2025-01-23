<?php

namespace LaravelEnso\Categories\Http\Controllers\Image;

use Illuminate\Routing\Controller;
use LaravelEnso\Categories\Http\Requests\ValidateUpload;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Files\Models\File;

class Upload extends Controller
{
    public function __invoke(ValidateUpload $request, Category $category)
    {
        $oldFile = $category->file;

        $file = File::upload($category, $request->file('logo'));

        $category->file()->associate($file)->save();

        $oldFile?->delete();

        return ['fileId' => $category->file->id];
    }
}
