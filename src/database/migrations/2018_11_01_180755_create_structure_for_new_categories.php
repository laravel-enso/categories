<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForNewCategories extends Migration
{
    protected $permissions = [
        ['name' => 'administration.categories.index', 'description' => 'Show index for categories', 'type' => Types::Read, 'is_default' => false],

        ['name' => 'administration.categories.create', 'description' => 'Create category', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.categories.store', 'description' => 'Store a new category', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.categories.show', 'description' => 'Show category', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.categories.edit', 'description' => 'Edit category', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.categories.update', 'description' => 'Update category', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.categories.destroy', 'description' => 'Delete category', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'administration.categories.initTable', 'description' => 'Init table for categories', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.categories.tableData', 'description' => 'Get table data for categories', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.categories.exportExcel', 'description' => 'Export excel for categories', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'administration.categories.options', 'description' => 'Get category options for select', 'type' => Types::Read, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Categories', 'icon' => 'swatchbook', 'route' => 'administration.categories.index', 'order_index' => 90, 'has_children' => false
    ];

    protected $parentMenu = 'Administration';
}

