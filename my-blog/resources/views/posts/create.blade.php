
<!DOCTYPE html>
<html>
<head>
    <title>Create a Post</title>
</head>
<body>

    @extends('layouts.app')

    @section('title', 'All Posts')

    @section('content')
        <h1 class="text-2xl font-bold p-2">Create a New Post</h1>
        
        <a href="{{ route('posts.create') }}" class="text-blue-500 hover:text-blue-700">Create New Post</a>

        <form action="{{ route('posts.store') }}" method="POST" class="mt-4">

            @csrf

            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" required class="border border-gray-300 rounded-md p-2 w-full">

            <br><br>

            <label class="block text-sm font-medium text-gray-700">Body</label>
            <textarea name="body" required class="border border-gray-300 rounded-md p-2 w-full"></textarea>

            <br><br>

            <label>
                <input type="checkbox" name="is_published" value="1" class="mr-2">
                Publish this post
            </label>

            <br><br>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Post
            </button>

        </form>

        <br/>
        <a href="{{ route('posts.index') }}" class="text-blue-500 hover:text-blue-700">Back to Posts</a>
    @endsection
</body>
</html>
