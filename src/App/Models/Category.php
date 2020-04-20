<?php

namespace LaravelEnso\Categories\App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\App\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Tables\App\Traits\TableCache;

class Category extends Model
{
    use AvoidsDeletionConflicts, TableCache;

    protected $fillable = ['id', 'parent_id', 'name', 'order_index'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('order_index')
            ->with('subcategories');
    }

    public function scopeTopLevel(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public static function move(int $id, int $orderIndex, ?int $parentId)
    {
        self::whereId($id)->update([
            'parent_id' => $parentId,
            'order_index' => $orderIndex,
        ]);

        self::whereParentId($parentId)
            ->orderBy('order_index')
            ->orderByDesc('updated_at')
            ->get()
            ->each(fn ($category, $index) => $category
                ->update(['order_index' => $index + 1]));
    }

    public static function tree()
    {
        return self::topLevel()
            ->orderBy('order_index')
            ->with('subcategories')->get();
    }
}
