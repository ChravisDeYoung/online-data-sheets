<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $search = request('search');
        return view('users.index', ['users' => User::search($search)->paginate(10)]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:7|max:255',
        ]);

        User::create($attributes);

        return redirect('/users')->with('success', 'New account has been created.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }
}
