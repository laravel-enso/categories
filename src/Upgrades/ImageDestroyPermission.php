<?php

namespace LaravelEnso\Categories\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class ImageDestroyPermission implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'administration.categories.image.destroy', 'description' => 'Delete uploaded image for a parent category', 'is_default' => false],
    ];

    public function roles(): array
    {
        return Permission::whereName('administration.categories.update')
            ->first()->roles->pluck('name')
            ->toArray();
    }
}
