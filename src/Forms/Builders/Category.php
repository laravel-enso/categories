<?php

namespace LaravelEnso\Categories\Forms\Builders;

use LaravelEnso\Categories\Models\Category as Model;
use LaravelEnso\Forms\Services\Form;

class Category
{
    private const TemplatePath = __DIR__.'/../Templates/category.json';

    protected Form $form;

    public function __construct()
    {
        $this->form = new Form($this->templatePath());
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Model $category)
    {
        $levelOne = $category->recursiveParent?->recursiveParent;

        return $this->form
            ->value('levelOne', $levelOne?->id)
            ->showTab('Image')
            ->value('image_id', $category->image?->id)
            ->edit($category);
    }

    protected function templatePath(): string
    {
        return self::TemplatePath;
    }
}
