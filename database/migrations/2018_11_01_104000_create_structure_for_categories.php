<?php

use LaravelEnso\Migrator\Database\Migration;

return new class extends Migration
{
    protected array $permissions = [
        ['name' => 'administration.categories.index', 'description' => 'Show index for categories', 'is_default' => false],
        ['name' => 'administration.categories.create', 'description' => 'Create category', 'is_default' => false],
        ['name' => 'administration.categories.edit', 'description' => 'Edit category', 'is_default' => false],
        ['name' => 'administration.categories.initTable', 'description' => 'Init table for category', 'is_default' => false],
        ['name' => 'administration.categories.tableData', 'description' => 'Get table data for category', 'is_default' => false],
        ['name' => 'administration.categories.options', 'description' => 'Get options for select', 'is_default' => false],
        ['name' => 'administration.categories.store', 'description' => 'Store a new category', 'is_default' => false],
        ['name' => 'administration.categories.move', 'description' => 'Move category', 'is_default' => false],
        ['name' => 'administration.categories.update', 'description' => 'Update category', 'is_default' => false],
        ['name' => 'administration.categories.destroy', 'description' => 'Delete category', 'is_default' => false],
        ['name' => 'administration.categories.upload', 'description' => 'Upload logo for a parent category', 'is_default' => false],
        ['name' => 'administration.categories.image.destroy', 'description' => 'Upload logo for a parent category', 'is_default' => false]
    ];

    protected array $menu = [
        'name' => 'Categories', 'icon' => 'tags', 'route' => 'administration.categories.index', 'order_index' => 90, 'has_children' => false,
    ];

    protected ?string $parentMenu = 'Administration';
};
