<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
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
        return view('users.create', [
            'roles' => Role::select('id', 'description')
                ->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse The redirect response after storing the user.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $user = User::create($attributes);
        $user->roles()->attach(request('roles'));

        return redirect(route('users.index'))
            ->with([
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
        return view('users.edit', [
            'user' => $user->load('roles:id'),
            'roles' => Role::select('id', 'description')
                ->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $attributes = $request->validated();

        $user->update($attributes);

        $user->roles()->sync(request('roles'));

        return back()->with([
            'status' => 'success',
            'message' => 'User updated'
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user): RedirectResponse
    {
        $attributes = $request->validated();

        $user->update([
            'password' => ($attributes['password'])
        ]);

        return back()->with([
            'status' => 'success',
            'message' => 'Password updated'
        ]);
    }
}
