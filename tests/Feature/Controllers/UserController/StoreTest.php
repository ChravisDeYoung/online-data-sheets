<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('requires authentication', function () {
    $userData = User::factory()->make()->toArray();

    post(route('users.store'), $userData)
        ->assertRedirect(route('sessions.create'));
});

it('can create a user', function () {
    $userData = User::factory()->make()->toArray();
    $userData['password'] = 'password';
    $userData['password_confirmation'] = $userData['password'];

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData);

    assertDatabaseHas(User::class, [
        'first_name' => $userData['first_name'],
        'last_name' => $userData['last_name'],
        'email' => $userData['email'],
        'phone_number' => $userData['phone_number'],
    ]);
});

it('redirects to the users index', function () {
    $userData = User::factory()->make()->toArray();
    $userData['password'] = 'password';
    $userData['password_confirmation'] = $userData['password'];

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData)
        ->assertRedirect(route('users.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'New user has been created.'
        ]);
});

it('requires a valid first name', function ($value) {
    $userData = User::factory()
        ->make(['first_name' => $value])
        ->toArray();
    $userData['password'] = 'password';
    $userData['password_confirmation'] = $userData['password'];

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData)
        ->assertInvalid('first_name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid last name', function ($value) {
    $userData = User::factory()
        ->make(['last_name' => $value])
        ->toArray();
    $userData['password'] = 'password';
    $userData['password_confirmation'] = $userData['password'];

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData)
        ->assertInvalid('last_name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid email', function ($value) {
    User::factory()
        ->create(['email' => 'duplicate@email.com',]);

    $userData = User::factory()
        ->make(['email' => $value])
        ->toArray();
    $userData['password'] = 'password';
    $userData['password_confirmation'] = $userData['password'];

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData)
        ->assertInvalid('email');
})
    ->with([null, 1, 1.5, true, 'invalid-email', str_repeat('a', 255) . '@email.com', 'duplicate@email.com']);

it('requires a valid phone number', function ($value) {
    $userData = User::factory()
        ->make(['phone_number' => $value])
        ->toArray();
    $userData['password'] = 'password';
    $userData['password_confirmation'] = $userData['password'];

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData)
        ->assertInvalid('phone_number');
})
    ->with([null, 1, 1.5, true, 'invalid-phone', '020 7946 0958']);

it('requires a valid password', function ($value) {
    $userData = User::factory()
        ->make()
        ->toArray();
    $userData['password'] = $value;
    $userData['password_confirmation'] = $value === 'not-matched' ? 'not-matched-other' : $value;

    actingAs(User::factory()->create())
        ->post(route('users.store'), $userData)
        ->assertInvalid('password');
})
    ->with([null, 1, 1.5, true, 'short', str_repeat('a', 256), 'not-matched']);
