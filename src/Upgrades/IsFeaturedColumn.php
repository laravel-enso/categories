<?php

namespace LaravelEnso\Categories\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class IsFeaturedColumn implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasColumn('categories', 'is_featured');
    }

    public function migrateTable(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_featured')
                ->index()
                ->after('order_index');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_featured')->default(null)->change();
        });
    }
}
