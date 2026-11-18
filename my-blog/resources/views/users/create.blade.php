@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 border border-gray-200">
            {{-- LEFT: REGISTER FORM --}}
            <div class="bg-white p-8 sm:p-12 lg:p-14">

                <div class="mb-10">
                    <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-3">
                        Get Started
                    </p>

                    <h2 class="font-serif text-4xl sm:text-5xl text-gray-950 mb-4">
                        Join Us.
                    </h2>

                    <p class="text-sm text-gray-500">
                        Create your account and start writing.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="border border-red-200 bg-red-50 text-red-700 p-4 mb-6 text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('users.store') }}" method="POST" class="space-y-7">
                    @csrf

                    {{-- NAME --}}
                    <div>
                        <label class="block text-xs uppercase tracking-[0.15em] text-gray-600 mb-2">
                            Your Name
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            placeholder="Your name"
                            class="w-full border-0 border-b border-gray-300 px-0 py-3 text-sm focus:border-gray-950 focus:ring-0 outline-none transition"
                        >
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-xs uppercase tracking-[0.15em] text-gray-600 mb-2">
                            Email Address
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="w-full border-0 border-b border-gray-300 px-0 py-3 text-sm focus:border-gray-950 focus:ring-0 outline-none transition"
                        >
                    </div>

                    {{-- PASSWORD --}}
                    <div>
                        <label class="block text-xs uppercase tracking-[0.15em] text-gray-600 mb-2">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="At least 8 characters"
                            class="w-full border-0 border-b border-gray-300 px-0 py-3 text-sm focus:border-gray-950 focus:ring-0 outline-none transition"
                        >

                        <p class="text-xs text-gray-400 mt-2">
                            Use at least 8 characters.
                        </p>
                    </div>

                    {{-- SUBMIT --}}
                    <button
                        type="submit"
                        class="w-full bg-gray-950 text-white py-4 text-xs uppercase tracking-[0.2em] hover:bg-gray-700 transition cursor-pointer"
                    >
                        Create Account
                    </button>
                </form>

                <div class="border-t border-gray-200 mt-10 pt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Already have an account?

                        <a href="{{ route('login') }}"
                           class="text-gray-950 font-semibold underline underline-offset-4 hover:text-gray-500 transition">
                            Login here
                        </a>
                    </p>
                </div>
            </div>

            {{-- RIGHT: INTRODUCTION --}}
            <div class="hidden lg:flex flex-col justify-between bg-gray-950 text-white p-12">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-8">
                        Join the Community
                    </p>

                    <h1 class="font-serif text-5xl leading-tight mb-6">
                        Your voice.<br>
                        Your stories.
                    </h1>

                    <p class="text-gray-400 leading-relaxed max-w-sm">
                        Create an account and start sharing the stories, ideas, and moments worth writing about.
                    </p>
                </div>

                <p class="text-xs uppercase tracking-[0.2em] text-gray-500">
                    A space for every story.
                </p>
            </div>
        </div>
    </div>
@endsection