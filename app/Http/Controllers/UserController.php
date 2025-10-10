<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        return view('users.index', ['users' => User::orderBy('name')->get()]);
    }

    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }
}
