<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ContentController extends Controller
{
    /**
     * Display a paginated listing of content with optional search.
     */
    public function index(Request $request): View
    {
        $query = Content::query()
            // 1. Check publication status inside JSON settings or root column
            ->where(function ($q) {
                $q->where('setting->published', true)
                    ->orWhere('setting->published', 1)
                    ->orWhere('setting->status', 'published')
                    ->orWhere('published', true);
            })
            // 2. Check published_at date inside JSON settings or root column
            ->where(function ($q) {
                $q->whereNull('setting->published_at')
                    ->orWhere('setting->published_at', '')
                    ->orWhere('setting->published_at', '<=', now())
                    ->orWhereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('created_at');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $contents = $query->paginate(12)->withQueryString();

        $page = (object) [
            'title' => 'All Content',
            'seo_title' => 'All Content & Articles',
            'seo_description' => 'Browse our latest published content.',
            'is_indexable' => true,
            'is_followable' => true,
        ];

        return view('content.index', compact('contents', 'page'));
    }

    /**
     * Display a specific content item by slug.
     */
    public function show(Content $content): View
    {
        // 1. Verify publication status from setting or root column
        $isPublished = (bool) ($content->published ?? ($content->setting['published'] ?? false));
        $statusIsPublished = ($content->setting['status'] ?? null) === 'published';

        // 2. Resolve published_at timestamp from setting array or model property
        $rawPublishedAt = $content->setting['published_at'] ?? $content->published_at;
        $publishedAt = $rawPublishedAt ? Carbon::parse($rawPublishedAt) : null;

        $isFuture = $publishedAt && $publishedAt->isFuture();

        // 3. Abort if unpublished or scheduled for the future
        if ((!$isPublished && !$statusIsPublished) || $isFuture) {
            abort(404);
        }

        $relatedContents = Content::query()
            ->where('id', '!=', $content->id)
            ->where(function ($q) {
                $q->where('setting->published', true)
                    ->orWhere('setting->published', 1)
                    ->orWhere('setting->status', 'published')
                    ->orWhere('published', true);
            })
            ->where(function ($q) {
                $q->whereNull('setting->published_at')
                    ->orWhere('setting->published_at', '')
                    ->orWhere('setting->published_at', '<=', now())
                    ->orWhereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('created_at')
            ->take(3)
            ->get();

        return view('content.show', [
            'page' => $content,
            'relatedContents' => $relatedContents,
        ]);
    }
}
