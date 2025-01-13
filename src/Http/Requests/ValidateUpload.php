<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Categories\Models\Category;
use LaravelEnso\Helpers\Traits\MapsRequestKeys;

class ValidateUpload extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return ['logo' => 'required|image'];
    }
}
