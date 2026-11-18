
@extends('layouts.app')

@section('title', 'All Stories')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- PAGE HEADING --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">
                    THE STORY ARCHIVE
                </p>

                <h1 class="font-serif text-4xl md:text-6xl font-bold leading-tight">
                    Explore Our Stories
                </h1>

                <p class="text-sm text-gray-500 mt-4 max-w-lg">
                    Discover ideas, perspectives, and stories worth spending time with.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                {{-- SEARCH --}}
                <form action="{{ route('posts.index') }}" method="GET" class="flex">
                    <input
                        type="text"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="Search stories..."
                        class="border border-gray-300 px-4 py-3 text-sm w-full sm:w-64 focus:outline-none focus:border-black transition">

                    <button type="submit"
                        class="bg-black text-white px-5 py-3 text-xs uppercase tracking-wider hover:bg-gray-700 transition cursor-pointer">
                        Search
                    </button>
                </form>

                {{-- CLEAR SEARCH --}}
                @if (request('keyword'))
                    <a href="{{ route('posts.index') }}"
                        class="border border-gray-300 px-4 py-3 text-xs uppercase tracking-wider text-gray-600 hover:border-black hover:text-black transition text-center">
                        Clear
                    </a>
                @endif
            </div>
        </div>


        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="border-l-4 border-green-600 bg-green-50 text-green-700 p-4 mb-8 text-sm">
                {{ session('success') }}
            </div>
        @endif


        {{-- RESULTS HEADING --}}
        <div class="flex justify-between items-center border-b border-gray-300 pb-4 mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-gray-500">
                    Browse the collection
                </p>
            </div>

            <p class="text-xs text-gray-500">
                {{ $posts->total() }} {{ Str::plural('story', $posts->total()) }}
            </p>
        </div>


        {{-- POSTS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-14">
            @forelse ($posts as $post)
                <article class="group min-w-0">
                    {{-- COVER IMAGE --}}
                    <a href="{{ route('posts.show', $post) }}"
                        class="block overflow-hidden mb-5 bg-gray-100">
                        @if ($post->image_path)
                            <img
                                src="{{ asset('storage/' . $post->image_path) }}"
                                alt="{{ $post->title }}"
                                class="w-full aspect-[4/3] object-cover transition duration-700 group-hover:scale-105">
                        @else
                            <div class="w-full aspect-[4/3] flex items-center justify-center">
                                <span class="font-serif text-gray-400 text-lg">
                                    No image available
                                </span>
                            </div>
                        @endif
                    </a>


                    {{-- CATEGORY AND STATUS --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        @if ($post->category)
                            <a href="{{ route('categories.show', $post->category->slug) }}"
                                class="text-xs uppercase tracking-[0.2em] text-gray-500 hover:text-black transition">
                                {{ $post->category->name }}
                            </a>
                        @else
                            <span class="text-xs uppercase tracking-[0.2em] text-gray-400">
                                Uncategorized
                            </span>
                        @endif

                        @if ($post->is_published)
                            <span class="text-[10px] uppercase tracking-wider text-green-700 border border-green-200 px-2 py-1">
                                Published
                            </span>
                        @else
                            <span class="text-[10px] uppercase tracking-wider text-amber-700 border border-amber-200 px-2 py-1">
                                Draft
                            </span>
                        @endif
                    </div>


                    {{-- TITLE --}}
                    <h2 class="font-serif text-2xl md:text-3xl leading-tight mb-4 group-hover:text-gray-500 transition min-w-0 max-w-full break-words [overflow-wrap:anywhere]">
                        <a href="{{ route('posts.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </h2>


                    {{-- EXCERPT --}}
                    <p class="text-sm text-gray-600 leading-relaxed mb-5 min-w-0 max-w-full [overflow-wrap:anywhere]">
                        {{ Str::limit(strip_tags($post->body), 140) }}
                    </p>


                    {{-- AUTHOR, DATE AND LIKES --}}
                    <div class="border-t border-gray-200 pt-4 flex flex-wrap justify-between items-center gap-2 text-xs text-gray-500">

                        <span>
                            By
                            <a href="{{ route('users.show', $post->user) }}"
                                class="text-black font-semibold hover:underline">
                                {{ $post->user?->name ?? 'Unknown author' }}
                            </a>
                        </span>

                        <span>
                            {{ $post->created_at->format('M d, Y') }}
                        </span>

                        <span class="flex items-center gap-1">
                            <span class="text-red-500">♥</span>
                            {{ $post->likes_count ?? $post->likes()->count() }}
                        </span>

                    </div>


                    {{-- POST ACTIONS --}}
                    @canany(['update', 'delete'], $post)
                        <div class="flex items-center gap-5 mt-4 text-xs uppercase tracking-wider">
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="text-gray-600 hover:text-black hover:underline transition">
                                    Edit Story
                                </a>
                            @endcan

                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this post?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 hover:underline transition cursor-pointer">
                                        Delete
                                    </button>

                                </form>
                            @endcan
                        </div>
                    @endcanany
                </article>
            @empty

                {{-- EMPTY STATE --}}
                <div class="col-span-full text-center py-24 border-y border-gray-200">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4">
                        Nothing to read yet
                    </p>

                    <h2 class="font-serif text-3xl font-bold mb-4">
                        No stories found.
                    </h2>

                    <p class="text-sm text-gray-500 mb-8">
                        @if (request('keyword'))
                            Try searching with a different keyword.
                        @else
                            There are no stories here just yet.
                        @endif
                    </p>

                    @if (request('keyword'))
                        <a href="{{ route('posts.index') }}"
                            class="inline-block bg-black text-white px-6 py-3 text-xs uppercase tracking-wider hover:bg-gray-700 transition">
                            View All Stories
                        </a>
                    @else
                        <a href="{{ route('posts.create') }}"
                            class="inline-block bg-black text-white px-6 py-3 text-xs uppercase tracking-wider hover:bg-gray-700 transition">
                            Write the First Story
                        </a>
                    @endif
                </div>
            @endforelse
        </div>


        {{-- PAGINATION --}}
        @if ($posts->hasPages())
            <div class="border-t border-gray-300 mt-16 pt-8">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif


        {{-- BOTTOM MESSAGE --}}
        <div class="border-t border-gray-300 mt-16 pt-10 text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-3">
                End of the collection
            </p>

            <h2 class="font-serif text-2xl md:text-3xl font-bold">
                Every story deserves to be read.
            </h2>
        </div>
    </div>
@endsection