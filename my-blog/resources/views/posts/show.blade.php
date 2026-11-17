@extends('layouts.app')

@section('title', e($post->title) . ' | B<OG')

@section('content')

    <article class="max-w-3xl mx-auto py-10">

        {{-- BACK TO HOME --}}
        <a href="{{ route('home') }}"
            class="text-sm text-gray-500 hover:text-black">
            ← Back to Home
        </a>

        {{-- ARTICLE HEADER --}}
        <header class="text-center mt-10 mb-10">

            <p class="uppercase tracking-[0.2em] text-xs text-gray-500 mb-5">
                {{ $post->user->name }}
            </p>

            @if ($post->category)
                <p class="text-sm uppercase tracking-widest text-gray-500 mt-2">
                    {{ $post->category->name }}
                </p>
            @endif

            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-6">
                {{ $post->title }}
            </h1>

            <p class="text-sm text-gray-400">
                {{ $post->created_at->format('F d, Y') }}
            </p>

        </header>

        {{-- COVER IMAGE --}}
        @if ($post->image_path)
            <img
                src="{{ asset('storage/' . $post->image_path) }}"
                alt="{{ $post->title }}"
                class="w-full max-h-[500px] object-cover mb-10"
            >
        @endif

        {{-- ARTICLE BODY --}}
        <div class="text-gray-800 text-lg leading-8 whitespace-pre-line">
            {{ $post->body }}
        </div>

        {{-- BACK TO HOME --}}
        <div class="border-t border-gray-300 mt-12 pt-6">
            <a href="{{ route('home') }}"
                class="text-sm font-semibold hover:underline">
                ← Explore more stories
            </a>
        </div>

    </article>

@endsection