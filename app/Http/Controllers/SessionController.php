<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        session()->regenerate();

        return redirect('/dashboard')->with([
            'status' => 'success',
            'message' => 'Welcome back!'
        ]);
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/login')->with([
            'status' => 'success',
            'message' => 'Goodbye!'
        ]);
    }
}
