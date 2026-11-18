@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="max-w-5xl mx-auto">
        {{-- PAGE HEADER --}}
        <div class="border-b border-gray-300 pb-8 mb-10">
            <a href="{{ route('users.show', $user) }}"
                class="text-xs uppercase tracking-widest text-gray-500 hover:text-black transition">
                ← Back to profile
            </a>

            <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mt-10 mb-3">
                YOUR ACCOUNT
            </p>

            <h1 class="font-serif text-4xl md:text-6xl font-bold">
                Edit Your Profile.
            </h1>

            <p class="text-sm text-gray-500 mt-4">
                Keep your account information up to date.
            </p>
        </div>


        {{-- PROFILE FORM --}}
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_280px] gap-12 items-start">
            {{-- LEFT: FORM --}}
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- NAME --}}
                <div class="mb-10">
                    <label for="name" class="block text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                        Display Name
                    </label>

                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        maxlength="255"
                        class="w-full border-b border-gray-300 py-4 text-xl md:text-2xl font-serif focus:outline-none focus:border-black transition bg-transparent">

                    @error('name')
                        <p class="text-red-500 text-sm mt-3">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-xs text-gray-400 mt-3">
                        This is the name other readers will see on your stories and profile.
                    </p>
                </div>


                {{-- EMAIL --}}
                <div class="mb-10">
                    <label for="email" class="block text-xs uppercase tracking-[0.2em] text-gray-500 mb-4">
                        Email Address
                    </label>

                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border-b border-gray-300 py-4 text-base focus:outline-none focus:border-black transition bg-transparent">

                    @error('email')
                        <p class="text-red-500 text-sm mt-3">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-xs text-gray-400 mt-3">
                        Your email address is used for your account.
                    </p>
                </div>


                {{-- FORM ACTIONS --}}
                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('users.show', $user) }}"
                        class="w-full sm:w-auto text-center border border-gray-300 px-7 py-4 text-xs font-bold uppercase tracking-[0.2em] hover:border-black transition">
                        Cancel
                    </a>

                    <button type="submit"
                        class="w-full sm:w-auto bg-black text-white px-7 py-4 text-xs font-bold uppercase tracking-[0.2em] hover:bg-gray-700 transition cursor-pointer">
                        Save Changes →
                    </button>
                </div>
            </form>


            {{-- RIGHT: ACCOUNT INFORMATION --}}
            <aside class="border-t lg:border-t-0 lg:border-l border-gray-200 pt-8 lg:pt-0 lg:pl-8">
                <p class="text-xs uppercase tracking-[0.2em] text-gray-500 mb-5">
                    Account Information
                </p>

                <div class="mb-6">
                    <p class="font-serif text-xl font-bold break-words">
                        {{ $user->name }}
                    </p>

                    <p class="text-sm text-gray-500 mt-1 break-all">
                        {{ $user->email }}
                    </p>
                </div>

                <div class="border-t border-gray-200 pt-5">
                    <p class="text-xs uppercase tracking-widest text-gray-400 mb-2">
                        Member Since
                    </p>

                    <p class="text-sm">
                        {{ $user->created_at->format('F Y') }}
                    </p>
                </div>

                <p class="text-sm text-gray-500 leading-relaxed mt-8">
                    Your profile represents you as a writer in our community. Keep your information accurate and
                    recognizable.
                </p>
            </aside>
        </div>


        {{-- BOTTOM NOTE --}}
        <div class="border-t border-gray-300 mt-16 pt-8 text-center">
            <p class="font-serif text-xl md:text-2xl italic text-gray-500">
                "Every writer has a story beyond the page."
            </p>

        </div>
    </div>
@endsection
