@extends('layouts.app')

@section('title', $user->name . ' | Profile')

@section('content')
    <div class="max-w-8xl mx-auto">
        {{-- PROFILE HEADER --}}
        <section class="border-b border-gray-300 pb-10 mb-12">
            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-8">
                {{-- AUTHOR INFORMATION --}}
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-4">
                        Author Profile
                    </p>

                    <h1 class="font-serif text-4xl md:text-6xl font-bold break-words [overflow-wrap:anywhere]">
                        {{ $user->name }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-5">
                        Member since {{ $user->created_at->format('F Y') }}
                    </p>
                </div>

                {{-- EDIT PROFILE --}}
                @if (auth()->id() === $user->id)
                    <a href="{{ route('profile.edit') }}"
                        class="inline-block border border-gray-300 px-6 py-3 text-xs font-bold uppercase tracking-[0.2em] hover:border-black transition">
                        Edit Profile →
                    </a>
                @endif
            </div>

            {{-- AUTHOR STATISTICS --}}
            <div class="flex flex-wrap gap-12 mt-10 pt-6 border-t border-gray-200">
                <div>
                    <p class="font-serif text-3xl font-bold">
                        {{ $posts->total() }}
                    </p>

                    <p class="text-xs uppercase tracking-widest text-gray-500 mt-2">
                        Published Stories
                    </p>
                </div>
            </div>
        </section>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="border border-green-200 bg-green-50 text-green-700 text-sm p-4 mb-10">
                {{ session('success') }}
            </div>
        @endif

        {{-- PUBLISHED STORIES --}}
        <section>
            {{-- SECTION HEADING --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 border-b border-gray-300 pb-5 mb-8">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-2">
                        From the Author
                    </p>

                    <h2 class="font-serif text-3xl md:text-4xl font-bold">
                        Published Stories
                    </h2>
                </div>

                <p class="text-xs uppercase tracking-widest text-gray-500">
                    {{ $posts->total() }} {{ $posts->total() === 1 ? 'Story' : 'Stories' }}
                </p>
            </div>

            {{-- POSTS GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                @forelse ($posts as $post)
                    <article class="group min-w-0">
                        {{-- COVER IMAGE --}}
                        <a href="{{ route('posts.show', $post) }}" class="block overflow-hidden mb-5">
                            @if ($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                    class="w-full aspect-[3/4] object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full aspect-[3/4] bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400 font-serif text-lg">
                                        No image available
                                    </span>
                                </div>
                            @endif
                        </a>


                        {{-- CATEGORY AND STATUS --}}
                        <div class="flex justify-between items-center gap-3 mb-4">
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

                            <span
                                class="text-[10px] uppercase tracking-wider text-green-700 border border-green-200 px-2 py-1">
                                Published
                            </span>
                        </div>

                        {{-- TITLE --}}
                        <h3
                            class="font-serif text-2xl md:text-3xl leading-tight mb-4 break-words [overflow-wrap:anywhere] group-hover:text-gray-500 transition">
                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        {{-- DESCRIPTION --}}
                        <p class="text-sm text-gray-600 leading-relaxed mb-5 min-w-0 max-w-full [overflow-wrap:anywhere]">
                            {{ Str::limit(strip_tags($post->body), 140) }}
                        </p>

                        {{-- DATE --}}
                        <div class="border-t border-gray-200 pt-4 text-xs text-gray-400">
                            {{ $post->created_at->format('F d, Y') }}
                        </div>
                    </article>
                @empty

                    <div class="col-span-full text-center py-20 border-y border-gray-200">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-4">
                            Nothing here just yet
                        </p>

                        <h3 class="font-serif text-2xl md:text-3xl font-bold mb-3">
                            No published stories.
                        </h3>

                        <p class="text-sm text-gray-500">
                            This author hasn't shared any stories with the world yet.
                        </p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="mt-14">
                {{ $posts->links() }}
            </div>
        </section>

        {{-- BOTTOM NOTE --}}
        <div class="border-t border-gray-300 mt-16 pt-8 text-center">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-3">
                Keep discovering
            </p>

            <a href="{{ route('home') }}" class="font-serif text-2xl md:text-3xl font-bold hover:text-gray-500 transition">
                Explore more stories →
            </a>
        </div>
    </div>
@endsection
