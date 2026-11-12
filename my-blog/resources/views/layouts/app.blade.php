<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow-md p-4">
        <h1 class="text-2xl font-bold">My Blog</h1>

        <nav class="mt-2 flex gap-4">
            <a href="{{ route('posts.index') }}">Home</a>
            <a href="{{ route('posts.create') }}">Create Post</a>
        </nav>
    </header>

    <hr>

    <main class="max-w-4xl mx-auto p-6">
        @yield('content')
    </main>
</body>
</html>