<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Primary relationship (and alias for Repeater / Filament)
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    public function items(): HasMany
    {
        return $this->menuItems();
    }

    /**
     * Top-level root items with eager loaded nested children
     */
    public function rootItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children.children']);
    }

    /**
     * Static resolver to fetch a menu by Slug, ID, or direct Model instance.
     */
    public static function resolve(mixed $identifier): ?self
    {
        if ($identifier instanceof self) {
            return $identifier;
        }

        $query = static::query();

        if (\Illuminate\Support\Facades\Schema::hasColumn('menus', 'is_active')) {
            $query->where('is_active', true);
        }

        if (is_numeric($identifier)) {
            return $query->where('id', $identifier)->with('rootItems')->first();
        }

        if (is_string($identifier)) {
            return $query->where('slug', $identifier)->orWhere('name', $identifier)->with('rootItems')->first();
        }

        return null;
    }
}
