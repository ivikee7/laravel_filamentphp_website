@extends('layouts.app')

@section('title', $page->title ?? 'Page')

@section('content')
    <article class="w-full">
        @if(!empty($page->content) && is_array($page->content))
            @foreach($page->content as $block)
                <x-blocks.dispatcher :block="$block" />
            @endforeach
        @else
            <div class="max-w-4xl mx-auto py-16 px-4 text-center text-gray-500">
                <p class="text-lg">No content available for this page.</p>
            </div>
        @endif
    </article>
@endsection
