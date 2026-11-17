@extends('layouts.app')

@section('title', 'B<OG')

@section('content')
    {{-- HERO SECTION --}}
    <section class="text-center py-8 border-b border-gray-300">

        <p class="uppercase tracking-[0.3em] text-sm text-gray-500 mb-4">
            Stories, ideas & inspiration
        </p>

        <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6">
            Discover something <br> worth reading.
        </h1>

        <p class="text-gray-600 max-w-xl mx-auto">
            A collection of stories, thoughts, and perspectives
            from writers who have something to share.
        </p>

    </section>


    {{-- FEATURED STORY --}}
    @if ($featuredPost)

        <section class="py-12 border-b border-gray-300">

            <p class="uppercase tracking-[0.3em] text-xs text-gray-500 mb-6">
                Featured Story
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                {{-- FEATURED IMAGE --}}
                <div>

                    @if ($featuredPost->image_path)

                        <img
                            src="{{ asset('storage/' . $featuredPost->image_path) }}"
                            alt="{{ $featuredPost->title }}"
                            class="w-full h-80 object-cover"
                        >

                    @else

                        <div class="h-80 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">
                                No image available
                            </span>
                        </div>

                    @endif

                </div>


                {{-- FEATURED DETAILS --}}
                <div>

                    <p class="text-xs uppercase tracking-widest text-gray-500 mb-4">
                        {{ $featuredPost->user->name }}
                    </p>

                    @if ($featuredPost->category)
                        <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">
                            {{ $featuredPost->category->name }}
                        </p>
                    @endif

                    <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">
                        <a
                            href="{{ route('posts.show', $featuredPost) }}"
                            class="hover:underline"
                        >
                            {{ $featuredPost->title }}
                        </a>
                    </h2>

                    <p class="text-gray-600 leading-relaxed mb-5">
                        {{ Str::limit($featuredPost->body, 200) }}
                    </p>

                    <p class="text-sm text-gray-400 mb-5">
                        {{ $featuredPost->created_at->format('F d, Y') }}
                    </p>

                    <a
                        href="{{ route('posts.show', $featuredPost) }}"
                        class="text-sm font-semibold border-b border-black pb-1 hover:text-gray-500"
                    >
                        Read Story →
                    </a>

                </div>

            </div>

        </section>

    @endif


    {{-- LATEST STORIES --}}
    <section class="py-12">

        {{-- SECTION HEADING --}}
        <div class="flex justify-between items-center mb-8">

            <h2 class="text-2xl font-serif font-bold">
                Latest Stories
            </h2>

            <span class="text-sm text-gray-500">
                {{ $recentPosts->total() }} articles
            </span>

        </div>


        {{-- POST GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse ($recentPosts as $post)

                <article class="bg-white rounded-lg overflow-hidden shadow-sm">

                    {{-- POST IMAGE --}}
                    <a href="{{ route('posts.show', $post) }}">

                        @if ($post->image_path)

                            <img
                                src="{{ asset('storage/' . $post->image_path) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-56 object-cover hover:opacity-90 transition"
                            >

                        @else

                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-sm">
                                    No image available
                                </span>
                            </div>

                        @endif

                    </a>


                    {{-- POST DETAILS --}}
                    <div class="p-5">

                        <p class="text-xs uppercase tracking-widest text-gray-500 mb-3">
                            {{ $post->user->name }}
                        </p>

                        @if ($featuredPost->category)
                            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">
                                {{ $featuredPost->category->name }}
                            </p>
                        @endif

                        <h3 class="text-xl font-serif font-bold mb-3">

                            <a
                                href="{{ route('posts.show', $post) }}"
                                class="hover:underline"
                            >
                                {{ $post->title }}
                            </a>

                        </h3>

                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ Str::limit($post->body, 120) }}
                        </p>

                        <a
                            href="{{ route('posts.show', $post) }}"
                            class="text-sm font-semibold hover:underline"
                        >
                            Read More →
                        </a>

                    </div>

                </article>

            @empty

                <p class="text-gray-500 col-span-full text-center py-10">
                    No other stories yet. Check back soon!
                </p>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        <div class="mt-10">

            {{ $recentPosts->links() }}

        </div>

    </section>

@endsection