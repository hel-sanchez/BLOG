<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return $users;
    }

    public function create()
    {
        return view('users.create');
    }

    // JSONS
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($validated);

        return redirect()->route('login')
            ->with('success', 'Account created successfully! Please log in.');
    }
}
