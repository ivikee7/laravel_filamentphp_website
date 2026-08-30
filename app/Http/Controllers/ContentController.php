<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use App\Models\Tag;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display the dynamic homepage / frontpage.
     */
    public function home(Request $request)
    {
        $page = Content::frontpage()
            ->where(function ($q) {
                $q->where('setting->status', 'published')
                    ->orWhereNull('setting->status');
            })
            ->where(function ($q) {
                $q->whereNull('setting->published_at')
                    ->orWhere('setting->published_at', '<=', now()->toDateTimeString());
            })
            ->first();

        if (!$page) {
            return $this->index($request);
        }

        $meta = $page->meta ?? [];
        $settings = $page->setting ?? [];

        // 1. Handle Canonical / 301 Redirects
        if (!empty($meta['redirect_url'])) {
            return redirect($meta['redirect_url'], (int) ($meta['redirect_code'] ?? 301));
        }

        // 2. Handle Password Gate ONLY if requires_auth is true
        if (!empty($settings['requires_auth']) && !empty($settings['password_protection'])) {
            $sessionKey = 'content_auth_' . $page->id;

            if (!$request->session()->has($sessionKey)) {
                if ($request->isMethod('post')) {
                    if ($request->input('password') === $settings['password_protection']) {
                        $request->session()->put($sessionKey, true);
                        return redirect()->route('home');
                    }

                    return response()->view('content.password', [
                        'content' => $page,
                        'error'   => 'Incorrect password. Please try again.',
                    ], 403);
                }

                return response()->view('content.password', ['content' => $page]);
            }
        }

        return view('home', [
            'page' => $page,
        ]);
    }

    /**
     * Display searchable directory of published content.
     */
    public function index(Request $request)
    {
        $query = Content::with(['category', 'tags'])
            ->where(function ($q) {
                $q->where('setting->status', 'published')
                    ->orWhereNull('setting->status');
            })
            ->where(function ($q) {
                $q->whereNull('setting->published_at')
                    ->orWhere('setting->published_at', '<=', now()->toDateTimeString());
            })
            ->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'));
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->input('tag'));
            });
        }

        return view('content.index', [
            'contents'       => $query->paginate(9)->withQueryString(),
            'categories'     => Category::where('is_active', true)->has('contents')->withCount('contents')->get(),
            'tags'           => Tag::has('contents')->withCount('contents')->get(),
            'activeCategory' => $request->input('category'),
            'activeTag'      => $request->input('tag'),
        ]);
    }

    /**
     * Display a single content page / article.
     */
    public function show(Request $request, string $slug)
    {
        $content = Content::with(['category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $settings = $content->setting ?? [];
        $meta = $content->meta ?? [];

        // 1. Guard against draft viewing by unauthenticated admin users
        $isPublished = ($settings['status'] ?? 'published') === 'published';
        $isScheduled = !empty($settings['published_at']) && $settings['published_at'] > now()->toDateTimeString();

        if ((!$isPublished || $isScheduled) && !auth()->check()) {
            abort(404);
        }

        // 2. Handle SEO 301/302 Redirections
        if (!empty($meta['redirect_url'])) {
            return redirect($meta['redirect_url'], (int) ($meta['redirect_code'] ?? 301));
        }

        // 3. Password Check ONLY when requires_auth is true
        if (!empty($settings['requires_auth']) && !empty($settings['password_protection'])) {
            $sessionKey = 'content_auth_' . $content->id;

            if (!$request->session()->has($sessionKey)) {
                if ($request->isMethod('post')) {
                    if ($request->input('password') === $settings['password_protection']) {
                        $request->session()->put($sessionKey, true);
                        return redirect()->route('content.show', $content->slug);
                    }

                    return response()->view('content.password', [
                        'content' => $content,
                        'error'   => 'Incorrect password. Please try again.',
                    ], 403);
                }

                return response()->view('content.password', ['content' => $content]);
            }
        }

        // Related published items
        $relatedContents = Content::with(['category', 'tags'])
            ->where('id', '!=', $content->id)
            ->where(function ($q) {
                $q->where('setting->status', 'published')
                    ->orWhereNull('setting->status');
            })
            ->when($content->category_id, fn ($q) => $q->where('category_id', $content->category_id))
            ->latest()
            ->take(3)
            ->get();

        return view('content.show', [
            'content'         => $content,
            'relatedContents' => $relatedContents,
        ]);
    }
}
