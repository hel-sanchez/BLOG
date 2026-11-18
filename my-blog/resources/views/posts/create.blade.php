
@extends('layouts.app')

@section('title', 'Edit a Story')

@section('content')

    <div class="max-w-8xl mx-auto">

        {{-- PAGE HEADER --}}
        <div class="border-b border-gray-300 pb-8 mb-10">

            <a href="{{ route('posts.index') }}"
                class="text-xs uppercase tracking-widest text-gray-500 hover:text-black transition">
                ← Back to stories
            </a>

            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-10 mb-3">
                YOUR WRITING SPACE
            </p>

            <h1 class="font-serif text-4xl md:text-6xl font-bold">
                Edit Your Story.
            </h1>

            <p class="text-sm text-gray-500 mt-4">
                Every great story deserves another look. Make this one even better.
            </p>

        </div>


        {{-- EDIT POST FORM --}}
        <form action="{{ route('posts.update', $post->id) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_300px] lg:gap-12 items-start">

                {{-- LEFT COLUMN: WRITING --}}
                <div class="min-w-0">

                    {{-- TITLE --}}
                    <div class="mb-10">

                        <label for="title"
                            class="block text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                            Story Title
                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title', $post->title) }}"
                            placeholder="Give your story a title..."
                            maxlength="255"
                            required
                            class="w-full border-b border-gray-300 py-4 text-3xl md:text-4xl font-serif focus:outline-none focus:border-black transition placeholder:text-gray-300 bg-transparent">

                        <div class="flex justify-between items-center mt-3">

                            <p class="text-xs text-gray-400">
                                Maximum 10 words.
                            </p>

                            <p id="titleWordCount" class="text-xs text-gray-400">
                                0 / 10 words
                            </p>

                        </div>

                        @error('title')
                            <p class="text-red-500 text-sm mt-3">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- BODY --}}
                    <div class="mb-10">

                        <div class="flex justify-between items-center mb-4">

                            <label for="body"
                                class="text-xs uppercase tracking-[0.2em] text-gray-500">
                                Your Story
                            </label>

                            <span class="text-xs text-gray-400">
                                Take your time.
                            </span>

                        </div>

                        <textarea
                            name="body"
                            id="body"
                            rows="14"
                            required
                            placeholder="Start writing your story here..."
                            class="w-full border border-gray-300 p-5 md:p-6 text-base md:text-lg leading-[1.9] focus:outline-none focus:border-black transition resize-y bg-transparent">{{ old('body', $post->body) }}</textarea>

                        @error('body')
                            <p class="text-red-500 text-sm mt-3">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- RIGHT COLUMN: POST SETTINGS --}}
                <aside class="space-y-8">

                    {{-- COVER IMAGE --}}
                    <div>

                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                            Cover Image
                        </p>

                        <label for="image_path"
                            class="group block border border-dashed border-gray-300 p-5 text-center cursor-pointer hover:border-black transition">

                            <div id="upload_placeholder"
                                class="{{ $post->image_path ? 'hidden' : '' }} py-8">

                                <div class="text-3xl text-gray-400 mb-3">
                                    +
                                </div>

                                <p class="text-sm font-semibold mb-2">
                                    Upload a new cover image
                                </p>

                                <p class="text-xs text-gray-400">
                                    Click to browse your files
                                </p>

                            </div>

                            <img
                                src="{{ $post->image_path ? asset('storage/' . $post->image_path) : '' }}"
                                id="image_preview"
                                class="{{ $post->image_path ? '' : 'hidden' }} w-full aspect-[4/3] object-cover"
                                alt="Image preview">

                        </label>

                        <input
                            type="file"
                            name="image_path"
                            id="image_path"
                            accept="image/*"
                            class="sr-only">

                        <p class="text-xs text-gray-400 mt-3">
                            Choose an image that represents your story.
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Leave empty to keep your current image.
                        </p>

                        @error('image_path')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- CATEGORY --}}
                    <div>

                        <label for="category_id"
                            class="block text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                            Category
                        </label>

                        <select
                            name="category_id"
                            id="category_id"
                            class="w-full border border-gray-300 px-4 py-3 text-sm bg-transparent focus:outline-none focus:border-black transition">

                            <option value="">Choose a category</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    @selected(old('category_id', $post->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('category_id')
                            <p class="text-red-500 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- PUBLISH SETTINGS --}}
                    <div class="border-y border-gray-200 py-6">

                        <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                            Publication
                        </p>

                        <label class="flex items-start gap-3 cursor-pointer">

                            <input
                                type="checkbox"
                                name="is_published"
                                value="1"
                                @checked(old('is_published', $post->is_published))
                                class="mt-1 w-4 h-4 accent-black cursor-pointer">

                            <span>

                                <span class="block text-sm font-semibold">
                                    Publish this story
                                </span>

                                <span class="block text-xs text-gray-500 mt-1 leading-relaxed">
                                    Make your story visible to everyone.
                                    Leave unchecked to save it as a draft.
                                </span>

                            </span>

                        </label>

                    </div>


                    {{-- FORM ACTIONS --}}
                    <div class="space-y-3">

                        <button
                            type="submit"
                            class="w-full bg-black text-white py-4 text-xs font-bold uppercase tracking-[0.2em] hover:bg-gray-700 transition cursor-pointer">
                            Save Changes →
                        </button>

                        <a href="{{ route('posts.index') }}"
                            class="block w-full border border-gray-300 text-center py-4 text-xs font-bold uppercase tracking-[0.2em] hover:border-black transition">
                            Cancel
                        </a>

                    </div>

                </aside>

            </div>

        </form>


        {{-- DELETE POST --}}
        @can('delete', $post)

            <div class="border-t border-gray-200 mt-12 pt-6">

                <p class="text-xs uppercase tracking-[0.2em] text-gray-400 mb-4">
                    Danger Zone
                </p>

                <form action="{{ route('posts.destroy', $post->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to permanently delete this story?')">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="text-xs text-red-500 hover:text-red-700 hover:underline transition cursor-pointer">
                        Delete this story
                    </button>

                </form>

            </div>

        @endcan


        {{-- BOTTOM NOTE --}}
        <div class="border-t border-gray-300 pt-8 mt-12 text-center">

            <p class="font-serif text-xl md:text-2xl italic text-gray-500">
                "A story is a way to see the world differently."
            </p>

        </div>

    </div>

@endsection


@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // IMAGE PREVIEW
            const imageInput = document.getElementById('image_path');
            const imagePreview = document.getElementById('image_preview');
            const uploadPlaceholder = document.getElementById('upload_placeholder');

            imageInput.addEventListener('change', function () {

                const file = this.files[0];

                if (file) {
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                } else {
                    imagePreview.classList.add('hidden');
                    imagePreview.removeAttribute('src');
                    uploadPlaceholder.classList.remove('hidden');
                }

            });


            // TITLE WORD COUNT
            const titleInput = document.getElementById('title');
            const wordCountDisplay = document.getElementById('titleWordCount');

            function validateTitle() {

                const words = titleInput.value.trim().split(/\s+/).filter(Boolean);
                const count = titleInput.value.trim() === '' ? 0 : words.length;

                wordCountDisplay.textContent = `${count} / 10 words`;

                if (count > 10) {

                    titleInput.setCustomValidity('Your title cannot contain more than 10 words.');

                    wordCountDisplay.classList.add('text-red-500');
                    wordCountDisplay.classList.remove('text-green-600', 'text-gray-400');

                } else {

                    titleInput.setCustomValidity('');

                    wordCountDisplay.classList.remove('text-red-500');

                    if (count > 0) {
                        wordCountDisplay.classList.add('text-green-600');
                        wordCountDisplay.classList.remove('text-gray-400');
                    } else {
                        wordCountDisplay.classList.remove('text-green-600');
                        wordCountDisplay.classList.add('text-gray-400');
                    }

                }

            }

            titleInput.addEventListener('input', validateTitle);

            validateTitle();

        });
    </script>

@endsection
