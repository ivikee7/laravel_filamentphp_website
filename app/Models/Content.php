<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

#[Fillable([
    'category_id', 'title', 'slug', 'content', 'styles', 'meta', 'setting',
    'created_by',
])]
class Content extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'styles'  => 'array',
            'meta'    => 'array',
            'setting' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Content $content) {
            // Automatically assign creator ID if available
            if (!$content->exists && Auth::check() && !$content->created_by) {
                $content->created_by = Auth::id();
            }

            // Exclusive frontpage assignment
            $setting = $content->setting ?? [];
            $isFrontpage = !empty($setting['is_frontpage']);

            if ($isFrontpage) {
                static::query()
                    ->when($content->exists, fn ($q) => $q->where($content->getKeyName(), '!=', $content->getKey()))
                    ->where(function ($q) {
                        $q->where('setting->is_frontpage', true)
                            ->orWhere('setting->is_frontpage', 1);
                    })
                    ->get()
                    ->each(function ($model) {
                        $currentSettings = $model->setting ?? [];
                        $currentSettings['is_frontpage'] = false;
                        $model->setting = $currentSettings;
                        $model->saveQuietly();
                    });
            }

            // Slug auto-generation & collision handling
            if (!$content->slug || $content->isDirty('title') || $content->isDirty('slug')) {
                $sourceString = $content->slug ?: $content->title;
                $slug = Str::slug($sourceString);
                $originalSlug = $slug;
                $count = 1;

                while (
                static::withTrashed()
                    ->where('slug', $slug)
                    ->when($content->exists, fn ($q) => $q->where($content->getKeyName(), '!=', $content->getKey()))
                    ->exists()
                ) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $content->slug = $slug;
            }
        });
    }

    /**
     * Fallback magic getter to read nested setting/meta JSON keys
     * without interrupting Eloquent attribute resolution or relations.
     */
    public function __get($key)
    {
        $value = parent::__get($key);

        if ($value !== null) {
            return $value;
        }

        $setting = $this->getAttribute('setting');
        if (is_array($setting) && array_key_exists($key, $setting)) {
            return $setting[$key];
        }

        $meta = $this->getAttribute('meta');
        if (is_array($meta) && array_key_exists($key, $meta)) {
            return $meta[$key];
        }

        return null;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFrontpage(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('setting->is_frontpage', true)
                ->orWhere('setting->is_frontpage', 1);
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
