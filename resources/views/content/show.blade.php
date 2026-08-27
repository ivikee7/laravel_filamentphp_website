@extends('layouts.app')

@section('title', $page->seo['title'] ?? $page->title)

@push('head')
    @if(!empty($page->seo['description']))
        <meta name="description" content="{{ $page->seo['description'] }}">
    @endif
    @if(!empty($page->seo['canonical_url']))
        <link rel="canonical" href="{{ $page->seo['canonical_url'] }}">
    @endif
    @if(!empty($page->seo['noindex']))
        <meta name="robots" content="noindex, nofollow">
    @endif
    @if(!empty($page->setting['custom_css']))
        <style>{!! $page->setting['custom_css'] !!}</style>
    @endif
    @if(!empty($page->setting['header_scripts']))
        {!! $page->setting['header_scripts'] !!}
    @endif
@endpush

@section('content')
    <main class="w-full bg-slate-50 min-h-screen">
        @foreach($page->content ?? [] as $block)
            <x-blocks.dispatcher :block="$block" />
        @endforeach
    </main>
@endsection
