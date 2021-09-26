<?php

namespace LaravelEnso\Categories\Upgrades;

use LaravelEnso\Upgrade\Contracts\MigratesStructure;
use LaravelEnso\Upgrade\Traits\StructureMigration;

class Options implements MigratesStructure
{
    use StructureMigration;

    protected array $permissions = [
        ['name' => 'administration.categories.options', 'description' => 'Get options for select', 'is_default' => false],
    ];
}
