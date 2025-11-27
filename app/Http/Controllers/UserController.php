<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsible for managing users in the application.
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View The view for displaying the users.
     */
    public function index(): View
    {
        return view('users.index', [
            'users' => User::select('id', 'first_name', 'last_name', 'email', 'phone_number')
                ->search(request('search'))
                ->orderBy('id')
                ->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View The view for creating a new user.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse The redirect response after storing the user.
     */
    public function store(): RedirectResponse
    {
        $attributes = $this->validateUser();

        User::create($attributes);

        return redirect(route('users.index'))->with([
            'status' => 'success',
            'message' => 'New user has been created.'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user The user to be edited.
     * @return View The view for editing the user.
     */
    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
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

    /**
     * Validate the user data.
     *
     * @param User|null $user The user instance being validated, or null if a new instance is being created.
     * @return array The validated data.
     */
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
