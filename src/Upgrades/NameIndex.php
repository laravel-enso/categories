<?php

namespace LaravelEnso\Categories\Upgrades;

use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class NameIndex implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasIndex('categories', 'categories_name_index');
    }

    public function migrateTable(): void
    {
        Schema::table('categories', fn ($table) => $table->index(['name']));
    }
}
