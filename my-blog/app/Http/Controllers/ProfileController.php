<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Public profile
    public function show(User $user)
    {
        $posts = $user->posts()
            ->where('is_published', true)
            ->with('category')
            ->latest()
            ->paginate(6);

        return view('profiles.show', compact('user', 'posts'));
    }

    // Edit own profile
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('profiles.edit', compact('user'));
    }

    // Save profile changes
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'Profile updated!');
    }
}