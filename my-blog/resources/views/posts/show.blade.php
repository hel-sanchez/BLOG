@extends('layouts.app')

@section('title', e($post->title) . ' | B<OG')

@section('content')

    <article class="max-w-3xl mx-auto py-10">

        {{-- BACK TO HOME --}}
        <a href="{{ auth()->check() ? route('posts.index') : route('home') }}"
            class="text-sm text-gray-500 hover:text-black">
            ← Go back
        </a>

        {{-- @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif --}}

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

            <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4">
                {{ $post->title }}
            </h1>

            <div class="flex justify-center">
                @auth
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 rounded-full
                                hover:bg-gray-100 transition cursor-pointer">

                            @if ($liked)
                                {{-- Filled red heart --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="w-6 h-6 text-red-500">
                                    <path d="M11.645 20.91a.75.75 0 0 0 .71 0
                                        c2.682-1.49 7.895-5.64 9.145-9.89
                                        C22.75 6.5 19.5 3.5 16 3.5
                                        c-1.9 0-3.4 1-4 2
                                        c-.6-1-2.1-2-4-2
                                        c-3.5 0-6.75 3-5.5 7.52
                                        c1.25 4.25 6.463 8.4 9.145 9.89Z"/>
                                </svg>
                            @else
                                {{-- Outline heart --}}
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    class="w-6 h-6 text-gray-500">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5
                                        -1.935 0-3.597 1.126-4.312 2.733
                                        -.715-1.607-2.377-2.733-4.313-2.733
                                        C5.1 3.75 3 5.765 3 8.25
                                        c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                                </svg>
                            @endif

                            <span class="text-sm text-gray-600">
                                {{ $post->likes_count }} Likes
                            </span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-500 hover:text-black">
                        Log in to like this post
                    </a>
                @endauth
            </div>

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