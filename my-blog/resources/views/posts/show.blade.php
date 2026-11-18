@extends('layouts.app')

@section('title', e($post->title) . ' | B&lt;OG')

@section('content')
    <article class="max-w-7xl mx-auto">
        {{-- BACK NAVIGATION --}}
        <div class="mb-10">
            <a href="{{ route('home') }}"
                class="text-xs uppercase tracking-widest text-gray-500 hover:text-black transition">
                ← Back to stories
            </a>
        </div>


        {{-- ARTICLE HEADER --}}
        <header class="max-w-4xl mx-auto text-center mb-12">
            {{-- CATEGORY --}}
            @if ($post->category)
                <a href="{{ route('categories.show', $post->category->slug) }}"
                    class="inline-block text-xs uppercase tracking-[0.25em] text-gray-500 border-b border-gray-300 pb-2 mb-6 hover:text-black hover:border-black transition">
                    {{ $post->category->name }}
                </a>
            @endif

            {{-- TITLE --}}
            <h1 class="font-serif text-4xl md:text-6xl font-bold leading-tight mb-8 break-words [overflow-wrap:anywhere]">
                {{ $post->title }}
            </h1>

            {{-- AUTHOR AND DATE --}}
            <div class="flex flex-wrap justify-center items-center gap-3 text-sm text-gray-500 mb-8">
                <span>By</span>

                <a href="{{ route('users.show', $post->user) }}" class="font-semibold text-black hover:underline">
                    {{ $post->user->name }}
                </a>

                <span>·</span>

                <span>{{ $post->created_at->format('F d, Y') }}</span>
            </div>

            {{-- LIKE BUTTON --}}
            <div class="flex justify-center">
                @auth
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="flex items-center gap-2 border border-gray-300 rounded-full px-5 py-2 hover:bg-gray-100 transition cursor-pointer">

                            @if ($liked)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 text-red-500">
                                    <path d="M11.645 20.91a.75.75 0 0 0 .71 0
                                                                c2.682-1.49 7.895-5.64 9.145-9.89
                                                                C22.75 6.5 19.5 3.5 16 3.5
                                                                c-1.9 0-3.4 1-4 2
                                                                c-.6-1-2.1-2-4-2
                                                                c-3.5 0-6.75 3-5.5 7.52
                                                                c1.25 4.25 6.463 8.4 9.145 9.89Z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" class="w-5 h-5 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5
                                                                -1.935 0-3.597 1.126-4.312 2.733
                                                                -.715-1.607-2.377-2.733-4.313-2.733
                                                                C5.1 3.75 3 5.765 3 8.25
                                                                c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            @endif

                            <span class="text-xs font-semibold text-gray-600">
                                {{ $post->likes_count }} Likes
                            </span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs text-gray-500 border border-gray-300 rounded-full px-5 py-2 hover:text-black hover:border-black transition">
                        Log in to like this story
                    </a>
                @endauth
            </div>
        </header>


        {{-- ARTICLE + COMMENTS LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_380px] gap-12 items-start">
            {{-- LEFT COLUMN: ARTICLE --}}
            <div class="min-w-0">

                {{-- COVER IMAGE --}}
                @if ($post->image_path)
                    <div class="mb-10">
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                            class="w-full max-h-[600px] object-cover">
                    </div>
                @endif

                {{-- ARTICLE BODY --}}
                <div class="max-w-3xl mx-auto">
                    <div class="text-gray-800 text-lg md:text-xl leading-[1.9] whitespace-pre-line">
                        {{ $post->body }}
                    </div>

                    {{-- AUTHOR FOOTER --}}
                    <div class="border-y border-gray-300 py-8 mt-14">
                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-3">
                            Written by
                        </p>

                        <a href="{{ route('users.show', $post->user) }}"
                            class="font-serif text-2xl font-bold hover:underline">
                            {{ $post->user->name }}
                        </a>

                        <p class="text-sm text-gray-500 mt-2">
                            Discover more stories from this writer.
                        </p>
                    </div>
                </div>
            </div>


            {{-- RIGHT COLUMN: DISCUSSION --}}
            <aside
                class="lg:sticky lg:top-6 lg:max-h-[calc(100vh-3rem)] lg:overflow-y-auto lg:border-l lg:border-gray-200 lg:pl-8">
                {{-- DISCUSSION HEADER --}}
                <div class="flex justify-between items-center border-b border-gray-300 pb-5 mb-8">
                    <h2 class="font-serif text-3xl font-bold">
                        Discussion
                    </h2>

                    <span class="text-sm text-gray-500">
                        {{ $post->comments->count() }} comments
                    </span>
                </div>


                {{-- SUCCESS MESSAGE --}}
                @if (session('success'))
                    <div class="bg-green-50 text-green-700 text-sm p-4 mb-6">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- COMMENT FORM --}}
                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10">
                        @csrf

                        <label for="body" class="block text-sm font-semibold mb-3">
                            Share your thoughts
                        </label>

                        <textarea id="body" name="body" rows="4" placeholder="Write something meaningful..."
                            class="w-full border border-gray-300 p-4 text-sm focus:outline-none focus:border-black transition resize-y"
                            required>{{ old('body') }}</textarea>

                        @error('body')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="flex justify-end mt-3">
                            <button type="submit"
                                class="bg-black text-white px-6 py-3 text-xs font-bold tracking-widest hover:bg-gray-700 transition cursor-pointer">
                                POST COMMENT →
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-[#f5f5f2] text-center p-6 mb-10">
                        <h3 class="font-serif text-2xl font-bold mb-3">
                            Join the conversation.
                        </h3>

                        <p class="text-sm text-gray-600 mb-5">
                            Create an account to share your thoughts and interact with writers.
                        </p>

                        <a href="{{ route('users.create') }}"
                            class="inline-block bg-black text-white px-6 py-3 text-xs font-bold tracking-widest hover:bg-gray-700 transition">
                            CREATE AN ACCOUNT
                        </a>

                        <p class="text-xs text-gray-500 mt-4">
                            Already a member?
                            <a href="{{ route('login') }}" class="underline text-black">
                                Log in
                            </a>
                        </p>
                    </div>
                @endauth


                {{-- DISPLAY COMMENTS --}}
                <div class="space-y-8">
                    @forelse ($post->comments as $comment)
                        <div class="border-b border-gray-200 pb-7">

                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <a href="{{ route('users.show', $comment->user) }}"
                                        class="font-semibold text-sm hover:underline">
                                        {{ $comment->user->name }}
                                    </a>

                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                {{-- DELETE COMMENT: OWNER ONLY --}}
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to delete this comment?')"
                                            class="text-xs text-red-500 hover:text-red-700 hover:underline cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>

                            <p class="text-gray-700 text-sm leading-relaxed mt-4 whitespace-pre-line">
                                {{ $comment->body }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-10">
                            No comments yet. Be the first to share your thoughts!
                        </p>
                    @endforelse
                </div>
            </aside>
        </div>


        {{-- BOTTOM NAVIGATION --}}
        <div class="border-t border-gray-300 mt-16 pt-8 text-center">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                Keep discovering
            </p>

            <a href="{{ route('home') }}" class="font-serif text-2xl font-bold hover:text-gray-500 transition">
                Explore more stories →
            </a>
        </div>

    </article>
@endsection
