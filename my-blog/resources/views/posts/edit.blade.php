 @extends('layouts.app')

 @section('title', 'All Posts')

 @section('content')
     <h1 class="text-2xl font-bold p-2">
         Edit Post</h1>

     <form action="{{ route('posts.update', $post->id) }}" method="POST" class="mt-4" enctype="multipart/form-data">

         @csrf
         @method('PUT')

         <div class="mb-4 mt-2">
             <input type="file" name="image_path" id="image_path" accept="image/*"
                 class="px-2 py-1 bg-gray-300 border-1 cursor-pointer">
             @error('image_path')
                 <p class="text-red-500 text-sm">{{ $message }}</p>
             @enderror
             @if ($post->image_path)
                 <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" id="image_preview"
                     class="rounded w-48 h-48 object-center object-cover" draggable="false">
             @else
                 <img id="image_preview" class="mt-4 w-64 h-64 object-cover rounded-lg" alt="Image preview">
             @endif
         </div>

         <label class="block text-sm font-medium text-gray-700">Title</label>
         <input type="text" name="title" value="{{ $post->title }}" required
             class="border border-gray-300 rounded-md p-2 w-full">

         <br><br>

         <label class="block text-sm font-medium text-gray-700">Body</label>
         <textarea name="body" required class="border border-gray-300 rounded-md p-2 w-full">{{ $post->body }}</textarea>

         <br><br>

         <label class="block text-sm font-medium text-gray-700">
             <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
             Publish this post
         </label>

         <br><br>

         <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
             Update Post
         </button>

     </form>

     <br>
     <div class="flex gap-4">
         <a href="{{ route('posts.index') }}"
             class="flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
         <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
             @csrf
             @method('DELETE')
             <button type="submit" onclick="return confirm('Are you sure you want to delete this post?')"
                 class="flex bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                 Delete
             </button>
         </form>
     </div>
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
