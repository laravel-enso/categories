<?php

namespace LaravelEnso\Categories\App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Tables\App\Traits\TableCache;

class Category extends Model
{
    use TableCache;

    protected $fillable = ['id', 'parent_id', 'name'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
