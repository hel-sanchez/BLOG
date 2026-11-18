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
        {{-- LOGO --}}
        <div class="flex justify-center items-center py-5 md:py-6 px-4">
            <a href="{{ route('home') }}"
                class="font-serif text-4xl sm:text-6xl md:text-8xl tracking-[0.12em] text-center">
                B&lt;OG
            </a>
        </div>

        {{-- CATEGORY NAVIGATION --}}
        <nav class="border-y border-gray-200 bg-white">
            <div
                class="flex items-center justify-start sm:justify-center gap-7 md:gap-12 px-5 py-4 text-[10px] sm:text-xs font-bold tracking-wider overflow-x-auto whitespace-nowrap">

                @foreach ($navCategories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                        class="hover:text-gray-500 transition shrink-0">
                        {{ strtoupper($category->name) }}
                    </a>
                @endforeach
            </div>
        </nav>


        {{-- USER NAVIGATION --}}
        <div class="border-b border-gray-200 bg-[#fafafa]">
            <div
                class="max-w-[1400px] mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                @auth
                    {{-- USER IDENTITY --}}
                    <div class="text-[10px] sm:text-xs tracking-wide text-gray-500 text-center sm:text-left min-w-0">
                        SIGNED IN AS
                        <span class="font-bold text-black ml-1 break-words">
                            {{ strtoupper(auth()->user()->name) }}
                        </span>
                    </div>

                    {{-- ACCOUNT ACTIONS --}}
                    <div
                        class="flex flex-wrap justify-center sm:justify-end items-center gap-x-5 gap-y-4 text-[10px] sm:text-xs font-semibold tracking-wide">
                        <a href="{{ route('posts.create') }}"
                            class="bg-black text-white px-4 py-3 hover:bg-gray-700 transition">
                            + WRITE A POST
                        </a>

                        <a href="{{ route('posts.my-posts') }}" class="hover:text-gray-500 transition">
                            MY POSTS
                        </a>

                        <a href="{{ route('users.show', auth()->user()) }}" class="hover:text-gray-500 transition">
                            PROFILE
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-black transition cursor-pointer">
                                LOG OUT
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div
                        class="w-full flex justify-center sm:justify-end items-center gap-6 text-xs font-semibold tracking-wide">
                        <a href="{{ route('login') }}" class="hover:text-gray-500 transition">
                            LOG IN
                        </a>

                        <a href="{{ route('users.create') }}"
                            class="border border-black px-4 py-2 hover:bg-black hover:text-white transition">
                            REGISTER
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 min-w-0">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#111111] text-white">
        <div class="max-w-[1400px] mx-auto px-5 sm:px-6 py-12 md:py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 md:gap-16 pb-12">
                {{-- BRAND --}}
                <div>
                    <a href="{{ route('home') }}" class="font-serif text-4xl tracking-[0.12em]">
                        B&lt;OG
                    </a>

                    <p class="text-gray-400 text-sm leading-relaxed mt-5 max-w-xs">
                        A place for stories, ideas, and perspectives.
                        Read something inspiring. Share something meaningful.
                    </p>
                </div>


                {{-- EXPLORE --}}
                <div>
                    <h3 class="text-xs font-bold tracking-[0.2em] mb-5">
                        EXPLORE
                    </h3>

                    <div class="flex flex-col gap-3 text-sm text-gray-400">
                        <a href="{{ route('home') }}" class="hover:text-white transition">
                            Home
                        </a>

                        @guest
                            <a href="{{ route('users.create') }}" class="hover:text-white transition">
                                Join the Community
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('posts.index') }}" class="hover:text-white transition">
                                All Posts
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- ACCOUNT --}}
                <div>
                    <h3 class="text-xs font-bold tracking-[0.2em] mb-5">
                        YOUR ACCOUNT
                    </h3>

                    <div class="flex flex-col gap-3 text-sm text-gray-400">
                        @guest
                            <a href="{{ route('login') }}" class="hover:text-white transition">
                                Log In
                            </a>

                            <a href="{{ route('users.create') }}" class="hover:text-white transition">
                                Create an Account
                            </a>
                        @endguest

                        @auth
                            <a href="{{ route('users.show', auth()->user()) }}" class="hover:text-white transition">
                                My Profile
                            </a>

                            <a href="{{ route('posts.create') }}" class="hover:text-white transition">
                                Write a Post
                            </a>
                        @endauth
                    </div>
                </div>
            </div>


            {{-- COPYRIGHT --}}
            <div
                class="border-t border-gray-700 pt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} B&lt;OG. All rights reserved.
                </p>

                <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-white transition">
                    BACK TO TOP ↑
                </a>
            </div>
        </div>
    </footer>
    @yield('scripts')
</body>

</html>
