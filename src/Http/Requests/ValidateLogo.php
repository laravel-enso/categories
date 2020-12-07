<?php

namespace LaravelEnso\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateLogo extends FormRequest
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
