@extends('layouts.app')

@section('title', $category->name . ' | B<OG')

@section('content')

    <section class="text-center py-8 border-b border-gray-300">
        <p class="uppercase tracking-widest text-sm text-gray-500 mb-3">
            Explore Category
        </p>

        <h1 class="text-4xl font-serif font-bold">
            {{ $category->name }}
        </h1>
    </section>

    <section class="py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse ($posts as $post)
                <article>
                    <h2 class="text-xl font-serif font-bold">
                        <a href="{{ route('posts.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="text-sm text-gray-500 mt-2">
                        By {{ $post->user->name }}
                    </p>

                    <p class="text-gray-600 mt-3">
                        {{ Str::limit($post->body, 120) }}
                    </p>
                </article>
            @empty
                <p class="text-gray-500 col-span-full text-center">
                    No published posts in this category yet.
                </p>
            @endforelse

        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </section>

@endsection