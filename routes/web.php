<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardTileController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldDataController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('companies', [CompanyController::class, 'index']);

        Route::get('/dashboard-tiles/create', [DashboardTileController::class, 'create'])
            ->name('dashboard-tiles.create');
        Route::get('/dashboard-tiles/{dashboardTile}/edit', [DashboardTileController::class, 'edit'])
            ->name('dashboard-tiles.edit');
        Route::get('/dashboard-tiles', [DashboardTileController::class, 'index'])
            ->name('dashboard-tiles.index');
        Route::post('/dashboard-tiles', [DashboardTileController::class, 'store'])
            ->name('dashboard-tiles.store');
        Route::patch('/dashboard-tiles/{dashboardTile}', [DashboardTileController::class, 'update'])
            ->name('dashboard-tiles.update');

        Route::get('fields/create', [FieldController::class, 'create'])
            ->name('fields.create');
        Route::get('fields/{field}/edit', [FieldController::class, 'edit'])
            ->name('fields.edit');
        Route::get('fields', [FieldController::class, 'index'])
            ->name('fields.index');
        Route::post('fields', [FieldController::class, 'store'])
            ->name('fields.store');
        Route::patch('fields/{field}', [FieldController::class, 'update'])
            ->name('fields.update');

        Route::get('field-data/history', [FieldDataController::class, 'history'])
            ->name('field-data.history');

        Route::get('pages/create', [PageController::class, 'create'])
            ->name('pages.create');
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])
            ->name('pages.edit');
        Route::get('pages', [PageController::class, 'index'])
            ->name('pages.index');
        Route::post('pages', [PageController::class, 'store'])
            ->name('pages.store');
        Route::patch('pages/{page}', [PageController::class, 'update'])
            ->name('pages.update');

        Route::get('notfications', [NotificationController::class, 'index'])
            ->name('notifications.index');
        Route::get('notfications/{notification}', [NotificationController::class, 'show'])
            ->missing(fn() => abort(404, 'Notification not found.'))
            ->name('notifications.show');

        Route::get('users/create', [UserController::class, 'create'])
            ->name('users.create');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');
        Route::get('users', [UserController::class, 'index'])
            ->name('users.index');
        Route::post('users', [UserController::class, 'store'])
            ->name('users.store');
        Route::patch('users/{user}', [UserController::class, 'update'])
            ->name('users.update');
    });

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboards.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboards.index');
    Route::get('/dashboard/{dashboardTileId}', [DashboardController::class, 'show'])
        ->name('dashboards.show');

    Route::get('pages/{page:slug}', [PageController::class, 'show'])
        ->middleware('role:admin,{page:slug}')
        ->missing(fn() => abort(404, 'Page not found.'))
        ->name('pages.show');

    Route::post('logout', [SessionController::class, 'destroy'])
        ->name('sessions.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])
        ->name('sessions.create');
    Route::post('/login', [SessionController::class, 'store'])
        ->name('sessions.store');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

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

