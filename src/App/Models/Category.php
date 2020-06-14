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

    public function recursiveParent()
    {
        return $this->parent()->with('parent');
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('order_index');
    }

    public function recursiveSubcategories()
    {
        return $this->subcategories()
            ->with('subcategories');
    }

    public function scopeTopLevel(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeHasChildren(Builder $query)
    {
        return $query->has('subcategories');
    }

    public function move(int $orderIndex, ?int $parentId)
    {
        $order = $orderIndex >= $this->order_index && $this->parent_id === $parentId
            ? 'asc'
            : 'desc';

        $this->update([
            'parent_id' => $parentId,
            'order_index' => $orderIndex,
        ]);

        self::whereParentId($parentId)
            ->orderBy('order_index')
            ->orderBy('updated_at', $order)
            ->get()
            ->each(fn ($category, $index) => $category
                ->update(['order_index' => $index + 1]));
    }

    public static function tree()
    {
        return self::topLevel()
            ->with('recursiveSubcategories')
            ->get();
    }

    public function isParent()
    {
        return $this->subcategories()->count() > 0;
    }
}
