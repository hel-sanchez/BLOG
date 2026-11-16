
@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="min-h-[75vh] flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

            <h2 class="text-3xl font-bold text-center text-gray-800">
                Welcome Back!
            </h2>

            <p class="text-center text-gray-500 mt-2 mb-8">
                Login to continue to your blog.
            </p>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 rounded-lg p-3 mb-5">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 rounded-lg p-3 mb-5">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="you@example.com"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password"
                    >
                </div>

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" value="1"
                        class="rounded border-gray-300">
                    Remember me
                </label>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition cursor-pointer"
                >
                    Login
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Don't have an account?
                <a href="{{ route('users.create') }}"
                    class="text-blue-600 hover:underline font-semibold cursor-pointer">
                    Register here
                </a>
            </p>

        </div>
    </div>
@endsection
