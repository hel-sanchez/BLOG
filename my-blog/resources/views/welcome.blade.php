
@extends('layouts.app')

@section('title', 'B<OG')

@section('content')
    {{-- HERO SECTION --}}
    <section class="text-center py-12 md:py-16">
        <p class="uppercase tracking-[0.3em] text-xs md:text-sm text-gray-500 mb-5">
            Stories, ideas & inspiration
        </p>

        <h1 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">
            Discover something
            <br>
            worth reading.
        </h1>

        <p class="text-gray-600 max-w-xl mx-auto leading-relaxed mb-8">
            A collection of stories, thoughts, and perspectives
            from writers who have something to share.
        </p>

        <a href="#subscribe"
            class="inline-block bg-black text-white px-7 py-3 text-xs font-semibold tracking-widest hover:bg-gray-700 transition">
            JOIN OUR COMMUNITY ↓
        </a>
    </section>


    {{-- FEATURED STORY --}}
    @if ($featuredPost)
        <section class="py-12 md:py-16 border-b border-gray-300">
            <div class="flex items-center gap-4 mb-8">
                <p class="uppercase tracking-[0.3em] text-xs text-gray-500">
                    Featured Story
                </p>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                {{-- FEATURED IMAGE --}}
                <a href="{{ route('posts.show', $featuredPost) }}"
                    class="block overflow-hidden">

                    @if ($featuredPost->image_path)
                        <img
                            src="{{ asset('storage/' . $featuredPost->image_path) }}"
                            alt="{{ $featuredPost->title }}"
                            class="w-full h-72 md:h-[420px] object-cover hover:scale-[1.02] transition duration-500"
                        >
                    @else
                        <div class="h-72 md:h-[420px] bg-gray-100 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">
                                No image available
                            </span>
                        </div>
                    @endif
                </a>


                {{-- FEATURED DETAILS --}}
                <div>
                    @if ($featuredPost->category)
                        <p class="text-xs uppercase tracking-widest text-gray-500 mb-3">
                            {{ $featuredPost->category->name }}
                        </p>
                    @endif

                    <h2 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-5 min-w-0 max-w-full [overflow-wrap:anywhere]">
                        <a href="{{ route('posts.show', $featuredPost) }}"
                            class="hover:text-gray-500 transition">
                            {{ $featuredPost->title }}
                        </a>
                    </h2>

                    <p class="text-base text-gray-700 leading-relaxed min-w-0 max-w-full [overflow-wrap:anywhere]">
                        {{ Str::limit($featuredPost->body, 220) }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-6">
                        <span>
                            By
                            <a href="{{ route('users.show', $featuredPost->user) }}"
                                class="font-semibold text-black hover:underline">
                                {{ $featuredPost->user->name }}
                            </a>
                        </span>

                        <span>·</span>

                        <span>
                            {{ $featuredPost->created_at->format('F d, Y') }}
                        </span>
                    </div>

                    <a href="{{ route('posts.show', $featuredPost) }}"
                        class="inline-block text-xs font-bold tracking-widest border-b border-black pb-2 hover:text-gray-500 hover:border-gray-500 transition">
                        READ FULL STORY →
                    </a>
                </div>
            </div>
        </section>
    @endif


    {{-- MOST LOVED STORIES --}}
    <section class="py-12 md:py-16 border-b border-gray-300">
        <div class="flex justify-between items-end gap-4 mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-2">
                    Reader Favorites
                </p>

                <h2 class="text-3xl md:text-4xl font-serif font-bold">
                    Most Loved Stories
                </h2>
            </div>

            <span class="hidden sm:block text-xs text-gray-500">
                THE MOST-LIKED ARTICLES
            </span>
        </div>


        @if ($popularPosts->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach ($popularPosts as $post)
                    <article class="group">
                        {{-- IMAGE --}}
                        <a href="{{ route('posts.show', $post) }}"
                            class="block overflow-hidden mb-4">

                            @if ($post->image_path)
                                <img
                                    src="{{ asset('storage/' . $post->image_path) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-48 object-cover group-hover:scale-[1.03] transition duration-500"
                                >
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">
                                        No image available
                                    </span>
                                </div>
                            @endif
                        </a>


                        {{-- DETAILS --}}
                        @if ($post->category)
                            <p class="text-[10px] uppercase tracking-widest text-gray-500 mb-2">
                                {{ $post->category->name }}
                            </p>
                        @endif

                        <h3 class="font-serif text-lg font-bold leading-snug mb-3 break-words [overflow-wrap:anywhere]">
                            <a href="{{ route('posts.show', $post) }}"
                                class="hover:text-gray-500 transition">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <div class="flex justify-between items-center text-xs text-gray-500">
                            <a href="{{ route('users.show', $post->user) }}"
                                class="hover:text-black hover:underline">
                                {{ $post->user->name }}
                            </a>

                            <span class="flex items-center gap-1">
                                <span class="text-red-500">♥</span>
                                {{ $post->likes_count }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        @else

            <p class="text-gray-500 text-center py-10">
                No reader favorites just yet. Be the first to show some love!
            </p>

        @endif
    </section>


    {{-- LATEST STORIES --}}
    <section class="py-12 md:py-16">

        {{-- SECTION HEADING --}}
        <div class="flex justify-between items-end gap-4 mb-8">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-2">
                    Freshly Published
                </p>

                <h2 class="text-3xl md:text-4xl font-serif font-bold">
                    Latest Stories
                </h2>
            </div>

            <span class="text-xs text-gray-500">
                {{ $recentPosts->total() }} articles
            </span>
        </div>


        {{-- POST GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
            @forelse ($recentPosts as $post)
                <article class="group">
                    {{-- POST IMAGE --}}
                    <a href="{{ route('posts.show', $post) }}"
                        class="block overflow-hidden mb-5">

                        @if ($post->image_path)
                            <img
                                src="{{ asset('storage/' . $post->image_path) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-64 object-cover group-hover:scale-[1.02] transition duration-500"
                            >
                        @else
                            <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">
                                    No image available
                                </span>
                            </div>
                        @endif
                    </a>


                    {{-- POST DETAILS --}}
                    <div>
                        @if ($post->category)
                            <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">
                                {{ $post->category->name }}
                            </p>
                        @endif

                        <h3 class="text-2xl font-serif font-bold leading-snug mb-3 break-words [overflow-wrap:anywhere]">
                            <a href="{{ route('posts.show', $post) }}"
                                class="hover:text-gray-500 transition">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <p class="text-gray-600 text-sm leading-relaxed mb-4">
                            {{ Str::limit($post->body, 140) }}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-4">
                            <a href="{{ route('users.show', $post->user) }}"
                                class="font-semibold text-black hover:underline">
                                {{ $post->user->name }}
                            </a>

                            <span>·</span>

                            <span>
                                {{ $post->created_at->format('F d, Y') }}
                            </span>
                        </div>

                        <a href="{{ route('posts.show', $post) }}"
                            class="text-xs font-bold tracking-widest border-b border-black pb-1 hover:text-gray-500 hover:border-gray-500 transition">
                            READ MORE →
                        </a>
                    </div>
                </article>
            @empty

                <p class="text-gray-500 col-span-full text-center py-10">
                    No stories yet. Check back soon!
                </p>
            @endforelse
        </div>


        {{-- PAGINATION --}}
        <div class="mt-12">
            {{ $recentPosts->links() }}
        </div>
    </section>


    {{-- JOIN / REGISTER SECTION --}}
    <section id="subscribe" class="bg-[#f5f5f2] text-center px-6 py-16 md:py-24">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-5">
            Your next favorite story starts here
        </p>

        <h2 class="text-4xl md:text-6xl font-serif font-bold mb-6">
            Be part of the story.
        </h2>

        <p class="text-gray-600 max-w-xl mx-auto leading-relaxed mb-8">
            Join a community of readers and writers.
            Discover new perspectives, share your ideas,
            and give your stories a place to be heard.
        </p>

        @guest
            <a href="{{ route('users.create') }}"
                class="inline-block bg-black text-white px-8 py-4 text-xs font-bold tracking-widest hover:bg-gray-700 transition">
                CREATE YOUR ACCOUNT →
            </a>

            <p class="text-xs text-gray-500 mt-5">
                Already a member?
                <a href="{{ route('login') }}" class="text-black underline">
                    Log in here
                </a>
            </p>
        @endguest

        @auth
            <a href="{{ route('posts.create') }}"
                class="inline-block bg-black text-white px-8 py-4 text-xs font-bold tracking-widest hover:bg-gray-700 transition">
                SHARE YOUR STORY →
            </a>
        @endauth
    </section>
@endsection