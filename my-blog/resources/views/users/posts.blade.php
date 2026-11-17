 @extends('layouts.app')

 @section('title', 'My Posts')

 @section('content')
     <div class="flex justify-between">
         <h1 class="text-2xl font-bold p-2">My Blog Posts ({{ $totalPosts }})</h1>

         <nav class="flex mb-5">
             <a href="{{ route('posts.my-posts', ['status' => 'all']) }}"
                 class="{{ $status === 'all' ? 'bg-blue-300 border-1 border:bg-blue-300' : '' }} px-2 py-1 rounded">
                 All
             </a>

             <a href="{{ route('posts.my-posts', ['status' => 'published']) }}"
                 class="{{ $status === 'published' ? 'bg-green-300 border-1 border:bg-green-300' : '' }} px-2 py-1 rounded">
                 Published
             </a>

             <a href="{{ route('posts.my-posts', ['status' => 'unpublished']) }}"
                 class="{{ $status === 'unpublished' ? 'bg-yellow-300 border-1 border:bg-yellow-300' : '' }} px-2 py-1 rounded">
                 Unpublished
             </a>
         </nav>
     </div>

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

         <div class="flex justify-between">
             <div class="flex gap-5">
                 @can('delete', $post)
                     <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                         onsubmit="return confirm('Are you sure you want to delete this post?')">
                         @csrf
                         @method('DELETE')

                         <button type="submit"
                             class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-800 cursor-pointer">Delete</button>
                     </form>
                 @endcan

                 @can('update', $post)
                     <a href="{{ route('posts.edit', $post->id) }}"
                         class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-800 cursor-pointer">
                         Edit
                     </a>
                 @endcan
             </div>

             <span class="{{ $post->is_published ? 'bg-green-500' : 'bg-yellow-500' }} text-white rounded px-2 py-1">
                 {{ $post->is_published ? 'Published' : 'Unpublished' }}
             </span>
         </div>

         <hr class="my-2">
     @endforeach

     {{ $posts->links() }}
 @endsection
