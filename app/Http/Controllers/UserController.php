<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', [
            'users' => User::search(request('search'))
                ->orderBy('id')
                ->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store()
    {
        $attributes = $this->validateUser();

        User::create($attributes);

        return redirect(route('users.index'))->with([
            'status' => 'success',
            'message' => 'New user has been created.'
        ]);
    }

    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateUser($user);

        // Only update password if it was provided
        if (!$request->filled('password')) {
            unset($validated['password']);
            unset($validated['password_confirmation']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with([
            'status' => 'success',
            'message' => 'User updated'
        ]);
    }

    private function validateUser(?User $user = null): array
    {
        $user ??= new User();

        // only validate password if we're creating the user or they are choosing to update password
        $passwordRequired = !$user->exists || request()->filled('password');

        return request()->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$user->id",
            'phone_number' => 'required|max:255|phone:CA',
            'password' => ($passwordRequired ? 'required|string|min:7|max:255|confirmed' : 'nullable'),
            'password_confirmation' => ($passwordRequired ? 'required|string|min:7|max:255' : 'nullable'),
        ]);
    }
}
