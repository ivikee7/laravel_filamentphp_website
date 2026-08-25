<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// 1. Import the Str facade

#[Fillable([
    'title', 'description', 'slug', 'content', 'is_frontpage',
    'image', 'published', 'published_at',
    'seo', 'meta', 'setting',
    'created_by', 'updated_by', 'deleted_by',
])]
class Content extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'published' => 'boolean',
            'meta' => 'array',
            'setting' => 'array',
            'seo' => 'array',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Content $content) {
            // 1. Assign authenticated user ID (only on initial creation)
            if (!$content->exists && Auth::check() && !$content->created_by) {
                $content->created_by = Auth::id();
            }

            // 2. Handle exclusive Frontpage logic
            if ($content->is_frontpage) {
                $frontpageQuery = static::where('is_frontpage', true);

                if ($content->exists) {
                    $frontpageQuery->where($content->getKeyName(), '!=', $content->getKey());
                }

                // Turn off frontpage flag for all other items
                $frontpageQuery->update(['is_frontpage' => false]);
            }

            // 3. Determine our starting slug string
            $sourceString = $content->slug ?: $content->title;

            // 4. Clean it up: converts spaces to hyphens, lowers casing, strips special characters
            $slug = Str::slug($sourceString);
            $originalSlug = $slug;
            $count = 1;

            // 5. Safely build the query builder instance
            $query = method_exists(static::class, 'bootSoftDeletes') ? static::withTrashed() : static::query();

            // 6. Exclude the current record from the unique check if it already exists
            if ($content->exists) {
                $query->where($content->getKeyName(), '!=', $content->getKey());
            }

            // 7. Loop safely to check both live and soft-deleted items
            while ($query->clone()->where('slug', $slug)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $content->slug = $slug;
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
