<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForCategories extends Migration
{
    protected array $permissions = [
        ['name' => 'administration.categories.index', 'description' => 'Show index for categories', 'is_default' => false],
        ['name' => 'administration.categories.store', 'description' => 'Store a new category', 'is_default' => false],
        ['name' => 'administration.categories.move', 'description' => 'Move category', 'is_default' => false],
        ['name' => 'administration.categories.update', 'description' => 'Update category', 'is_default' => false],
        ['name' => 'administration.categories.destroy', 'description' => 'Delete category', 'is_default' => false],
        ['name' => 'administration.categories.upload', 'description' => 'Upload logo for a category', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Categories', 'icon' => 'tags', 'route' => 'administration.categories.index', 'order_index' => 90, 'has_children' => false,
    ];

    protected ?string $parentMenu = 'Administration';
}
