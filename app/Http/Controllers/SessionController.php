<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controller responsible for handling user sessions.
 */
class SessionController extends Controller
{
    /**
     * Show the form for logging in a user.
     *
     * @return View The view for logging in a user.
     */
    public function create(): View
    {
        return view('sessions.create');
    }

    /**
     * Log in the user and store a new user session.
     *
     * @param SessionRequest $request The request containing the user credentials.
     * @return RedirectResponse The redirect response after logging in the user.
     */
    public function store(SessionRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        if (!auth()->attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Your provided credentials could not be verified.'
            ]);
        }

        session()->regenerate();

        return redirect()
            ->route('dashboards.index')
            ->with([
                'status' => 'success',
                'message' => 'Welcome back!'
            ]);
    }

    /**
     * Log out the user and destroy the current user session.
     *
     * @return RedirectResponse The redirect response after logging out the user.
     */
    public function destroy(): RedirectResponse
    {
        auth()->logout();

        return redirect()
            ->route('sessions.create')
            ->with([
                'status' => 'success',
                'message' => 'Goodbye!'
            ]);
    }
}
