@extends('layouts.app')

@section('title', 'Create Posts')

@section('content')
    <h1 class="text-2xl font-bold p-2">Create a New Post</h1>

    <form action="{{ route('posts.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">

        @csrf

        <div class="mb-4 mt-2">
            <input type="file" name="image_path" id="image_path" accept="image/*"
                class="px-2 py-1 bg-gray-300 border-1 cursor-pointer">
            <img id="image_preview" class="mt-4 w-64 h-64 object-cover rounded-lg" alt="Image preview">
            @error('image_path')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

        </div>

        <div class="mb-4 mt-2">
            <label class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="border border-gray-300 rounded-md p-2 w-full">

            @error('title')
                <p class="text-red-500 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Body</label>
            <textarea name="body" id="body" class="border border-gray-300 rounded-md p-2 w-full">{{ old('body') }}</textarea>

            @error('body')
                <p class="text-red-500 text-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block mb-2 font-semibold">
                Category
            </label>

            <select name="category_id" id="category_id" class="border rounded px-3 py-2 w-full">
                <option value="">Choose a category</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label>
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published')) class="mr-2">
                Publish this post
            </label>
        </div>

        <div class="flex justify-between">

            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                Create Post
            </button>

            <a href="{{ route('posts.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to Posts</a>
        </div>
    </form>

@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image_path');
            const imagePreview = document.getElementById('image_preview');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.classList.remove('hidden');
                } else {
                    imagePreview.classList.add('hidden');
                    imagePreview.removeAttribute('src');
                }
            });
        });
    </script>
@endsection
