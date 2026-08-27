@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center py-12">
        <div class="bg-red-50 text-red-600 font-extrabold text-7xl rounded-2xl px-6 py-4 mb-6 shadow-sm">
            500
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-3">Internal Server Error</h1>
        <p class="text-gray-600 max-w-md mb-8">
            Something went wrong on our end. Please try refreshing the page or check back later.
        </p>
        <a href="{{ route('home') }}" class="bg-indigo-600 text-white font-medium px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition">
            Back to Safety
        </a>
    </div>
@endsection
