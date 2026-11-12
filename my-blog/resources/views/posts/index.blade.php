<!DOCTYPE html>
<html>
<head>
    <title>My Blog</title>
</head>
<body>

    @extends('layouts.app')

    @section('title', 'All Posts')

    @section('content')

        <h1 class="text-2xl font-bold p-2">My Blog Posts</h1>

        @foreach ($posts as $post)

            <article class="border-b border-gray-300 pb-4 mb-4 p-4">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>

                <p class="text-gray-700">{{ $post->body }}</p>

                <p class="text-sm text-gray-500">
                    Published:
                    {{ $post->is_published ? 'Yes' : 'No' }}
                </p>

                <p class="text-sm text-gray-500">
                    Created at: {{ $post->created_at->format('Y-m-d H:i:s') }} <br/>
                    Updated at: {{ $post->updated_at->format('Y-m-d H:i:s') }}
                </p>
            </article>

            <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>

            <hr>

        @endforeach
    @endsection

</body>
</html>