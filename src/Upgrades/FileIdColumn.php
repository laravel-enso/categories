<?php

namespace LaravelEnso\Categories\Upgrades;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Upgrade\Contracts\MigratesTable;
use LaravelEnso\Upgrade\Helpers\Table;

class FileIdColumn implements MigratesTable
{
    public function isMigrated(): bool
    {
        return Table::hasColumn('categories', 'file_id');
    }

    public function migrateTable(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->bigInteger('file_id')->unsigned()->nullable()->unique();
            $table->foreign('file_id')->references('id')->on('files')
                ->onUpdate('restrict')->onDelete('restrict');
        });
    }
}
