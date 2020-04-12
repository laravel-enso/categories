<?php

use LaravelEnso\Migrator\App\Database\Migration;

class CreateStructureForCategories extends Migration
{
    protected $permissions = [
        ['name' => 'administration.categories.index', 'description' => 'Show index for categories', 'is_default' => false],

        ['name' => 'administration.categories.create', 'description' => 'Create category', 'is_default' => false],
        ['name' => 'administration.categories.store', 'description' => 'Store a new category', 'is_default' => false],
        ['name' => 'administration.categories.edit', 'description' => 'Edit category', 'is_default' => false],
        ['name' => 'administration.categories.update', 'description' => 'Update category', 'is_default' => false],
        ['name' => 'administration.categories.destroy', 'description' => 'Delete category', 'is_default' => false],
        ['name' => 'administration.categories.initTable', 'description' => 'Init table for categories', 'is_default' => false],
        ['name' => 'administration.categories.tableData', 'description' => 'Get table data for categories', 'is_default' => false],
        ['name' => 'administration.categories.exportExcel', 'description' => 'Export excel for categories', 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Categories', 'icon' => 'tags', 'route' => 'administration.categories.index', 'order_index' => 90, 'has_children' => false,
    ];

    protected $parentMenu = 'Administration';
}
