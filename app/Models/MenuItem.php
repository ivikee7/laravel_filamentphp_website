<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id',
        'parent_id',
        'name',
        'slug',
        'type',
        'url',
        'target',
        'left_icon',
        'right_icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (MenuItem $item) {
            if (empty($item->slug) && !empty($item->name)) {
                $item->slug = Str::slug($item->name);
            }
        });
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with('children');
    }

    public function getResolvedUrlAttribute(): string
    {
        return match ($this->type) {
            'external', 'internal' => $this->url ?? '#',
            'email'                => !empty($this->url) ? 'mailto:' . ltrim($this->url, 'mailto:') : '#',
            'telephone'            => !empty($this->url) ? 'tel:' . preg_replace('/[^0-9+]/', '', $this->url) : '#',
            default                => 'javascript:void(0)',
        };
    }
}
