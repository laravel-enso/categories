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
        return Table::hasColumn('categories', 'image_id');
    }

    public function migrateTable(): void
    {
        if (! Table::hasColumn('categories', 'file_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->bigInteger('image_id')->unsigned()->nullable()->after('parent_id')->unique();
                $table->foreign('image_id')->references('id')->on('files')
                    ->onUpdate('restrict')->onDelete('restrict');
            });
        } else {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign(['file_id']);
                $table->renameColumn('file_id', 'image_id');
                $table->foreign('image_id')->references('id')->on('files')
                    ->onUpdate('restrict')->onDelete('restrict');
            });
        }
    }
}
