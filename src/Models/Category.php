<?php

namespace LaravelEnso\Categories\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use LaravelEnso\Categories\Http\Resources\Label;
use LaravelEnso\Categories\Scopes\Ordered;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Files\Contracts\Attachable;
use LaravelEnso\Files\Contracts\OptimizesImages;
use LaravelEnso\Files\Contracts\PublicFile;
use LaravelEnso\Files\Contracts\ResizesImages;
use LaravelEnso\Files\Models\File;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Products\Models\Picture;
use LaravelEnso\Files\Http\Resources\Url;
use LaravelEnso\Tables\Traits\TableCache;

class Category extends Model implements Attachable, PublicFile, ResizesImages, OptimizesImages
{
    use AvoidsDeletionConflicts, Abilities, HasFactory, Rememberable, TableCache;

    protected $guarded = ['id'];

    protected $rememberableKeys = ['id', 'name'];

    public function label()
    {
        return new Label($this);
    }

    public function parent(): Relation
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function recursiveParent(): Relation
    {
        return $this->parent()->with('recursiveParent');
    }

    public function subcategories(): Relation
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function recursiveSubcategories(): Relation
    {
        return $this->subcategories()
            ->with('recursiveSubcategories');
    }

    public function image(): Relation
    {
        return $this->belongsTo(File::class);
    }

    public function pictureUrl(): string
    {
        return (new Url($this->image))?->url ?? Picture::defaultUrl();
    }

    public function imageWidth(): ?int
    {
        return 200;
    }

    public function imageHeight(): ?int
    {
        return 200;
    }

    public function scopeTopLevel(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeContains(Builder $query, string $items)
    {
        $query->whereHas($items);

        $this->nestedContains($query, $items);

        return $query;
    }

    public function move(int $orderIndex, ?int $parentId)
    {
        $oldParentId = $this->parent_id;

        $order = $orderIndex >= $this->order_index
            && $oldParentId === $parentId
            ? 'asc'
            : 'desc';

        $this->update([
            'parent_id' => $parentId,
            'order_index' => $orderIndex,
        ]);

        self::reorder($this->parent_id, $order);

        if ($oldParentId !== $this->parent_id) {
            self::reorder($oldParentId);
        }
    }

    public static function reorder(?int $parentId, string $order = 'asc')
    {
        self::whereParentId($parentId)
            ->orderBy('order_index', 'asc')
            ->orderBy('updated_at', $order)
            ->get()
            ->each(fn ($group, $index) => $group
                ->update(['order_index' => $index + 1]));
    }

    public static function tree(): Collection
    {
        return self::topLevel()
            ->with('recursiveSubcategories', 'image')
            ->get();
    }

    public function parentTree(): Collection
    {
        $category = $this;

        $tree = new Collection();

        while ($category = $category->recursiveParent) {
            $tree->prepend($category);
        }

        return $tree->map->setRelation('recursiveParent', null);
    }

    public function flattenCurrentAndBelowIds(): Collection
    {
        return $this->flattenCurrentAndBelow()
            ->pluck('id');
    }

    public function flattenCurrentAndBelow(): Collection
    {
        return $this->recursiveSubcategories
            ->map(fn ($cat) => $cat->flattenCurrentAndBelow())
            ->flatten()
            ->prepend($this);
    }

    public function isParent(): bool
    {
        return $this->subcategories()->exists();
    }

    public function level(): int
    {
        return $this->parent_id
            ? $this->parent->level() + 1
            : 0;
    }

    public function depth(): int
    {
        return $this->recursiveSubcategories
            ->map(fn ($category) => $category->depth() + 1)
            ->max() ?? 0;
    }

    protected static function booted()
    {
        static::addGlobalScope(new Ordered());
    }

    private function nestedContains(Builder $query, string $items, int $level = 0)
    {
        $maxLevel = Config::get('enso.categories.maxNestingLevel');

        $query->when($level < $maxLevel, fn ($query) => $query
            ->orWhereHas('subcategories', fn ($query) => $query->whereHas($items)
                ->orWhere(fn ($query) => $this->nestedContains($query, $items, $level + 1))));
    }

    public static function nextIndex(?int $parentId = null): int
    {
        return static::query()->whereParentId($parentId)
            ->max('order_index') + 1;
    }
}
