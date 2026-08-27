@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center py-12">
        <div class="bg-indigo-50 text-indigo-600 font-extrabold text-7xl rounded-2xl px-6 py-4 mb-6 shadow-sm">
            404
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-3">Page Not Found</h1>
        <p class="text-gray-600 max-w-md mb-8">
            Sorry, the page or content you are looking for does not exist or has been moved.
        </p>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="bg-indigo-600 text-white font-medium px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition">
                Go to Homepage
            </a>
            <a href="{{ route('content.index') }}" class="bg-white border border-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-lg hover:bg-gray-50 transition">
                Browse All Content
            </a>
        </div>
    </div>
@endsection
