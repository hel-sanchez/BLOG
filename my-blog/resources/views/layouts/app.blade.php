<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow-md p-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">My Blog</h1>

            @auth
                <nav class="flex items-center gap-4 cursor-pointer">
                    <a href="{{ route('posts.index') }}" class="hover:underline bg-gray-400 text-white p-1 rounded">Home</a>
                    <a href="{{ route('posts.create') }}" class="hover:underline bg-blue-500 text-white p-1 rounded">Create
                        Post</a>
                    <a href="{{ route('posts.my-posts') }}" class="hover:underline bg-green-500 text-white p-1 rounded">My
                        Posts</a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="hover:underline cursor-pointer bg-red-500 text-white p-1 rounded">Logout</button>
                    </form>
                </nav>
            @endauth

            @guest
                <nav class="flex items-center gap-4 cursor-pointer">
                    <a href="{{ route('login') }}" class="hover:underline bg-blue-500 text-white p-1 rounded">Login</a>
                    <a href="{{ route('users.create') }}"
                        class="hover:underline bg-green-500 text-white p-1 rounded">Register</a>
                </nav>
            @endguest
        </div>
    </header>

    <hr>

    <main class="max-w-4xl mx-auto p-6">
        @yield('content')
    </main>
</body>

</html>
