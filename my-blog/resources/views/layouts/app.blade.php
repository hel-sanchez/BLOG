<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'B&lt;OG')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-black">

    <header class="bg-[#f8f8f8]">

        <!-- Logo -->
        <div class="flex justify-center items-center py-6">
            <a href="{{ auth()->check() ? route('posts.index') : route('home') }}" class="font-serif text-6xl md:text-8xl tracking-[0.15em]">
                B&lt;OG
            </a>
        </div>

        <!-- Navigation -->
        <nav class="border-y border-gray-200 bg-white">
            <div
                class="flex flex-wrap justify-center items-center gap-8 md:gap-16 py-4 text-xs font-bold tracking-wider">
                @foreach ($navCategories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}" class="hover:text-gray-500">
                        {{ strtoupper($category->name) }}
                    </a>
                @endforeach

            </div>
        </nav>

        <!-- User Navigation -->
        <div class="flex justify-center items-center gap-5 py-3 text-sm">

            @auth
                <a href="{{ route('posts.create') }}" class="hover:underline">
                    Write a Post
                </a>

                <a href="{{ route('posts.my-posts') }}" class="hover:underline">
                    My Posts
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:underline cursor-pointer">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="hover:underline">
                    Login
                </a>

                <a href="{{ route('users.create') }}" class="hover:underline">
                    Register
                </a>
            @endguest

        </div>

    </header>

    <main class="max-w-[1400px] mx-auto px-6 py-12">
        @yield('content')
    </main>

    @yield('scripts')

</body>

</html>
