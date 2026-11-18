@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 border border-gray-200">

            {{-- LEFT: INTRODUCTION --}}
            <div class="hidden lg:flex flex-col justify-between bg-gray-950 text-white p-12">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400 mb-8">
                        Welcome Back
                    </p>

                    <h1 class="font-serif text-5xl leading-tight mb-6">
                        Every story<br>
                        starts somewhere.
                    </h1>

                    <p class="text-gray-400 leading-relaxed max-w-sm">
                        Pick up where you left off. Your writing space is waiting for you.
                    </p>
                </div>

                <p class="text-xs uppercase tracking-[0.2em] text-gray-500">
                    Read. Write. Share.
                </p>
            </div>

            {{-- RIGHT: LOGIN FORM --}}
            <div class="bg-white p-8 sm:p-12 lg:p-14">
                <div class="mb-10">
                    <p class="text-xs uppercase tracking-[0.25em] text-gray-500 mb-3">
                        Your Account
                    </p>

                    <h2 class="font-serif text-4xl sm:text-5xl text-gray-950 mb-4">
                        Sign In.
                    </h2>

                    <p class="text-sm text-gray-500">
                        Login to continue to your writing space.
                    </p>
                </div>

                @if (session('success'))
                    <div class="border border-green-200 bg-green-50 text-green-800 p-4 mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="border border-red-200 bg-red-50 text-red-700 p-4 mb-6 text-sm">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-7">
                    @csrf

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
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full border-0 border-b border-gray-300 px-0 py-3 text-sm focus:border-gray-950 focus:ring-0 outline-none transition"
                        >
                    </div>

                    {{-- REMEMBER ME --}}
                    <label class="flex items-center gap-3 text-sm text-gray-600 cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="rounded-sm border-gray-400 text-gray-950 focus:ring-gray-950"
                        >
                        Remember me
                    </label>

                    {{-- SUBMIT --}}
                    <button
                        type="submit"
                        class="w-full bg-gray-950 text-white py-4 text-xs uppercase tracking-[0.2em] hover:bg-gray-700 transition cursor-pointer"
                    >
                        Login to Your Account
                    </button>
                </form>

                <div class="border-t border-gray-200 mt-10 pt-6 text-center">
                    <p class="text-sm text-gray-500">
                        Don't have an account?

                        <a href="{{ route('users.create') }}"
                           class="text-gray-950 font-semibold underline underline-offset-4 hover:text-gray-500 transition">
                            Register here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection