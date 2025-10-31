<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardTileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');
    Route::get('/dashboard/{dashboardTileId}', [DashboardController::class, 'show'])
        ->name('dashboard.show');

    Route::get('/dashboard-tiles', [DashboardTileController::class, 'index'])
        ->name('dashboard-tiles.index');
    Route::get('/dashboard-tiles/create', [DashboardTileController::class, 'create'])
        ->name('dashboard-tiles.create');
    Route::post('/dashboard-tiles', [DashboardTileController::class, 'store'])
        ->name('dashboard-tiles.store');
    Route::get('/dashboard-tiles/{dashboardTile}/edit', [DashboardTileController::class, 'edit'])
        ->name('dashboard-tiles.edit');
    Route::patch('/dashboard-tiles/{dashboardTile}', [DashboardTileController::class, 'update'])
        ->name('dashboard-tiles.update');

    Route::get('companies', [CompanyController::class, 'index']);

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{user}/edit', [UserController::class, 'edit']);
    Route::patch('users/{user}', [UserController::class, 'update']);

    Route::post('logout', [SessionController::class, 'destroy']);

    Route::get('fields', [FieldController::class, 'index'])->name('fields.index');
    Route::get('fields/create', [FieldController::class, 'create']);
    Route::post('fields', [FieldController::class, 'store']);
    Route::get('fields/{field}/edit', [FieldController::class, 'edit']);
    Route::patch('fields/{field}', [FieldController::class, 'update']);

    Route::get('pages', [PageController::class, 'index'])
        ->name('pages.index');
    Route::get('pages/create', [PageController::class, 'create'])
        ->name('pages.create');
    Route::post('pages', [PageController::class, 'store'])
        ->name('pages.store');
    Route::get('pages/{page:slug}', [PageController::class, 'show'])
        ->name('pages.show');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])
        ->name('pages.edit');
    Route::patch('pages/{page}', [PageController::class, 'update'])
        ->name('pages.update');
});

Route::get('login', [SessionController::class, 'create'])->name('login');
Route::post('login', [SessionController::class, 'store'])->name('session.store');

//Route::post('/register', function () {
//    $validated = $this->validate(request(), [
//        'name' => 'required|string|max:255',
//        'email' => 'required|string|lowercase|email|max:255|unique:users',
//        'password' => 'required|string|min:8|confirmed', // Rules\Password::defaults()
//    ]);
//
////    event(new Registered(($user = User::create($validated))));
//    $user = User::create($validated);
//
//    Auth::login($user);
//
//    Session::regenerate();
//
////    $this->redirect(route('dashboard', absolute: false), navigate: true);
//});

//Route::get('/register', function () {
//    view('.register-test');
//});
//
//Route::post('/login', function () {
//    $this->validate();
//
//    $this->ensureIsNotRateLimited();
//
//    $user = $this->validateCredentials();
//
//    if (Features::canManageTwoFactorAuthentication() && $user->hasEnabledTwoFactorAuthentication()) {
//        Session::put([
//            'login.id' => $user->getKey(),
//            'login.remember' => $this->remember,
//        ]);
//
//        $this->redirect(route('two-factor.login'), navigate: true);
//
//        return;
//    }
//
//    Auth::login($user, $this->remember);
//
//    RateLimiter::clear($this->throttleKey());
//    Session::regenerate();
//
//    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

//});
//
//protected function validateCredentials(): User
//{
//    $user = Auth::getProvider()->retrieveByCredentials(['email' => $this->email, 'password' => $this->password]);
//
//    if (! $user || ! Auth::getProvider()->validateCredentials($user, ['password' => $this->password])) {
//        RateLimiter::hit($this->throttleKey());
//
//        throw ValidationException::withMessages([
//            'email' => __('auth.failed'),
//        ]);
//    }
//
//    return $user;
//}
//
///**
// * Ensure the authentication request is not rate limited.
// */
//protected function ensureIsNotRateLimited(): void
//{
//    if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
//        return;
//    }
//
//    event(new Lockout(request()));
//
//    $seconds = RateLimiter::availableIn($this->throttleKey());
//
//    throw ValidationException::withMessages([
//        'email' => __('auth.throttle', [
//            'seconds' => $seconds,
//            'minutes' => ceil($seconds / 60),
//        ]),
//    ]);
//}
//
///**
// * Get the authentication rate limiting throttle key.
// */
//protected function throttleKey(): string
//{
//    return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
//}

