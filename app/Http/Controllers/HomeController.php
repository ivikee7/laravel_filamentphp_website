<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with content marked for front page display.
     */
    public function __invoke(Request $request): View
    {
        $latestContent = Content::where('is_frontpage', true)
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('latestContent'));
    }
}
