@extends('layouts.app')

@section('title', 'My Stories')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- PAGE HEADER --}}
        <div class="border-b border-gray-300 pb-8 mb-10">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">
                YOUR WRITING SPACE
            </p>

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-5">
                <div>
                    <h1 class="font-serif text-4xl md:text-6xl font-bold">
                        My Stories.
                    </h1>

                    <p class="text-sm text-gray-500 mt-3">
                        Manage your published stories and unfinished drafts.
                    </p>
                </div>

                <a href="{{ route('posts.create') }}"
                    class="inline-block bg-black text-white px-6 py-4 text-xs font-bold uppercase tracking-[0.2em] hover:bg-gray-700 transition text-center">
                    + Write a Post
                </a>
            </div>
        </div>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="border border-green-200 bg-green-50 text-green-700 text-sm p-4 mb-8">
                {{ session('success') }}
            </div>
        @endif

        {{-- POST SUMMARY AND FILTERS --}}
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6 mb-10">
            {{-- TOTAL POSTS --}}
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-gray-400">
                    Your collection
                </p>

                <p class="font-serif text-3xl font-bold mt-1">
                    {{ $totalPosts }}
                    <span class="text-base font-normal text-gray-500">
                        {{ $totalPosts === 1 ? 'Story' : 'Stories' }}
                    </span>
                </p>
            </div>

            {{-- STATUS FILTERS --}}
            <nav class="flex flex-wrap gap-2 text-xs font-bold uppercase tracking-wider">
                <a href="{{ route('posts.my-posts', ['status' => 'all']) }}"
                    class="px-4 py-3 border transition
                    {{ $status === 'all'
                        ? 'bg-black text-white border-black'
                        : 'border-gray-300 text-gray-500 hover:border-black hover:text-black' }}">
                    All Stories
                </a>

                <a href="{{ route('posts.my-posts', ['status' => 'published']) }}"
                    class="px-4 py-3 border transition
                    {{ $status === 'published'
                        ? 'bg-black text-white border-black'
                        : 'border-gray-300 text-gray-500 hover:border-black hover:text-black' }}">
                    Published
                </a>

                <a href="{{ route('posts.my-posts', ['status' => 'unpublished']) }}"
                    class="px-4 py-3 border transition
                    {{ $status === 'unpublished'
                        ? 'bg-black text-white border-black'
                        : 'border-gray-300 text-gray-500 hover:border-black hover:text-black' }}">
                    Drafts
                </a>
            </nav>
        </div>

        {{-- POSTS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-x-7 gap-y-12">
            @forelse ($posts as $post)
                <article class="group min-w-0">
                    {{-- COVER IMAGE --}}
                    <a href="{{ $post->is_published ? route('posts.show', $post) : route('posts.edit', $post->id) }}"
                        class="block overflow-hidden mb-5 bg-gray-100">

                        @if ($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                class="w-full aspect-[4/3] object-cover transition duration-500 group-hover:scale-105"
                                draggable="false">
                        @else
                            <div class="w-full aspect-[4/3] flex items-center justify-center">
                                <span class="font-serif text-xl italic text-gray-400">
                                    No cover image
                                </span>
                            </div>
                        @endif
                    </a>

                    {{-- PUBLICATION STATUS AND DATE --}}
                    <div class="flex justify-between items-center gap-3 mb-4">
                        <span
                            class="text-[10px] font-bold uppercase tracking-[0.2em]
                            {{ $post->is_published ? 'text-green-700' : 'text-yellow-700' }}">

                            {{ $post->is_published ? '● Published' : '● Draft' }}

                        </span>

                        <span class="text-xs text-gray-400">
                            {{ $post->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    {{-- TITLE --}}
                    <h2
                        class="font-serif text-2xl md:text-3xl font-bold leading-tight mb-3 break-words [overflow-wrap:anywhere] group-hover:text-gray-500 transition">
                        <a
                            href="{{ $post->is_published ? route('posts.show', $post) : route('posts.edit', $post->id) }}">

                            {{ $post->title }}
                        </a>
                    </h2>

                    {{-- CATEGORY --}}
                    @if ($post->category)
                        <p class="text-xs uppercase tracking-widest text-gray-400 mb-4">
                            {{ $post->category->name }}
                        </p>
                    @endif

                    {{-- BODY PREVIEW --}}
                    <p class="text-sm text-gray-600 leading-relaxed mb-5 break-words [overflow-wrap:anywhere]">
                        {{ \Illuminate\Support\Str::limit($post->body, 180) }}
                    </p>

                    {{-- POST DETAILS --}}
                    <div class="border-t border-gray-200 pt-4 text-xs text-gray-400 space-y-1">
                        <p>
                            Last updated:
                            {{ $post->updated_at->format('M d, Y · h:i A') }}
                        </p>

                        @if ($post->created_at != $post->updated_at)
                            <p>
                                Edited after creation
                            </p>
                        @endif
                    </div>

                    {{-- ACTIONS --}}
                    <div class="flex flex-wrap items-center gap-5 mt-5 pt-4 border-t border-gray-200">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post->id) }}"
                                class="text-xs font-bold uppercase tracking-widest hover:text-gray-500 transition">
                                Edit Story →
                            </a>
                        @endcan

                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this story?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="text-xs font-bold uppercase tracking-widest text-red-500 hover:text-red-700 transition cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </article>
            @empty
                {{-- EMPTY STATE --}}
                <div class="col-span-full border-y border-gray-300 py-20 text-center">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4">
                        Nothing here yet
                    </p>

                    <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4">
                        Your next story starts here.
                    </h2>

                    <p class="text-sm text-gray-500 mb-8">
                        You haven't created any stories in this collection yet.
                    </p>

                    <a href="{{ route('posts.create') }}"
                        class="inline-block bg-black text-white px-7 py-4 text-xs font-bold uppercase tracking-[0.2em] hover:bg-gray-700 transition">
                        Write Your First Story →
                    </a>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if ($posts->hasPages())
            <div class="border-t border-gray-300 mt-16 pt-8">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif

        {{-- BOTTOM NOTE --}}
        <div class="border-t border-gray-300 mt-16 pt-8 text-center">
            <p class="font-serif text-xl md:text-2xl italic text-gray-500">
                "Keep writing. Your next story might be someone's favorite."
            </p>
        </div>
    </div>
@endsection
