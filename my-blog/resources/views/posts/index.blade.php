@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <h1 class="text-2xl font-bold p-2">All Blog Posts</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 rounded-lg p-3 mb-5">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($posts as $post)
        <article class="border-b border-gray-300 pb-4 mb-2 p-4">
            <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
            @if ($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image"
                    class="rounded w-48 h-48 object-center object-cover" draggable=False>
            @endif
            <p class="text-sm text-gray-500">By: {{ $post->user?->name ?? 'Unknown author' }}</p>
            <p class="text-gray-700">{{ $post->body }}</p>

            <p class="text-sm text-gray-500">
                Published:
                {{ $post->is_published ? 'Yes' : 'No' }}
            </p>

            <p class="text-sm text-gray-500">
                Created at: {{ $post->created_at->format('Y-m-d H:i:s') }} <br />
                Updated at: {{ $post->updated_at->format('Y-m-d H:i:s') }}
            </p>
        </article>

        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this post?')">
                @csrf
                @method('DELETE')

                <button type="submit">Delete</button>
            </form>
        @endcan

        @can('update', $post)
            <a href="{{ route('posts.edit', $post->id) }}">
                Edit
            </a>
        @endcan

        <hr class="my-4">
    @endforeach

    {{ $posts->links() }}
@endsection
