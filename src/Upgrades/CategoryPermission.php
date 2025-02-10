<?php

namespace LaravelEnso\Categories\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class CategoryPermission implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'administration.categories.create', 'description' => 'Create category', 'is_default' => false],
        ['name' => 'administration.categories.edit', 'description' => 'Edit category', 'is_default' => false],
        ['name' => 'administration.categories.initTable', 'description' => 'Init table for category', 'is_default' => false],
        ['name' => 'administration.categories.tableData', 'description' => 'Get table data for category', 'is_default' => false],
        ['name' => 'administration.categories.image.destroy', 'description' => 'Upload logo for a parent category', 'is_default' => false]
    ];

    public function roles(): array
    {
        return Permission::whereName('administration.categories.update')
            ->first()->roles->pluck('name')
            ->toArray();
    }
}
