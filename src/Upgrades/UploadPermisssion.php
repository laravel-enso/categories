<?php

namespace LaravelEnso\Categories\Upgrades;

use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class UploadPermisssion implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'administration.categories.upload', 'description' => 'Upload logo for a category', 'is_default' => false],
    ];

    protected array $roles;

    public function __construct()
    {
        $this->roles = Permission::whereName('administration.categories.update')
            ->first()->roles->pluck('name')
            ->toArray();
    }
}
