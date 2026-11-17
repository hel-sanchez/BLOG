
@extends('layouts.app')

@section('title', 'All Posts')

@section('content')

    <!-- Page heading and search -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mb-10">
        <div>
            <p class="text-xs tracking-[0.3em] text-gray-500 mb-2">
                THE LATEST STORIES
            </p>
            <h1 class="font-serif text-4xl md:text-5xl">
                Explore Our Stories
            </h1>
        </div>

        <form action="{{ route('posts.index') }}" method="GET" class="flex">
            <input
                type="text"
                id="searchInput"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="Search a story..."
                class="border border-gray-300 px-4 py-2 w-full md:w-64 focus:outline-none focus:border-black"
            >

            <button type="submit"
                class="bg-black text-white px-5 py-2 hover:bg-gray-700 transition">
                Search
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Posts grid -->
    <div id="postsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12">

        @forelse ($posts as $post)

            <article class="group min-w-0">

                <!-- Image -->
                <a href="#" class="block overflow-hidden mb-3">
                    @if ($post->image_path)
                        <img
                            src="{{ asset('storage/' . $post->image_path) }}"
                            alt="{{ $post->title }}"
                            class="w-full aspect-[3/4] object-cover transition duration-500 group-hover:scale-105"
                        >
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">No image available</span>
                        </div>
                    @endif
                </a>

                <!-- Publication status -->
                <p class="text-xs font-bold tracking-wider text-gray-500 mb-3">
                    {{ $post->is_published ? 'PUBLISHED' : 'DRAFT' }}
                </p>

                <!-- Title -->
                <h2 class="font-serif text-2xl leading-tight mb-3 group-hover:text-gray-500 transition">
                    {{ $post->title }}
                </h2>

                <!-- Author -->
                <p class="text-xs text-gray-500 mb-3">
                    By <span class="text-black uppercase">{{ $post->user?->name ?? 'Unknown author' }}</span>
                </p>

                <!-- Date -->
                <div class="border-t border-gray-200 pt-3 text-xs text-gray-400">
                    {{ $post->created_at->format('F d, Y') }}
                </div>

                <!-- Actions -->
                <div class="flex gap-4 mt-3 text-sm">

                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post->id) }}"
                            class="underline hover:text-gray-500">
                            Edit
                        </a>
                    @endcan

                    @can('delete', $post)
                        <form action="{{ route('posts.destroy', $post->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this post?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="underline hover:text-red-500">
                                Delete
                            </button>
                        </form>
                    @endcan

                </div>

            </article>

        @empty

            <p class="col-span-full text-center text-gray-500 py-16">
                No stories found.
            </p>

        @endforelse

    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $posts->withQueryString()->links() }}
    </div>

@endsection
