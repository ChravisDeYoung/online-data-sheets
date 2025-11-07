<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

it('requires authentication', function () {
    $user = User::factory()->create();

    patch(
        route('users.update', $user),
        ['first_name' => 'Updated Name'])
        ->assertRedirect(route('sessions.create'));
});

it('can update a user', function () {
    $user = User::factory()->create([
        'first_name' => 'First',
        'last_name' => 'Last',
        'email' => 'first.last@test.com',
        'phone_number' => '5192681650',
    ]);

    $updatedUserData = [
        'first_name' => 'First1',
        'last_name' => 'Last1',
        'email' => 'first.last1@test.com',
        'phone_number' => '5192681651',
    ];

    actingAs(User::factory()->create())
        ->patch(route('users.update', $user), $updatedUserData);

    assertDatabaseHas(User::class, $updatedUserData);
});

it('redirects to the users index', function () {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('users.update', $user),
            array_merge(
                $user->toArray(), ['first_name' => 'Updated Name']))
        ->assertRedirect(route('users.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'User updated'
        ]);
});

it('requires a valid first name', function ($value) {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('users.update', $user),
            array_merge($user->toArray(), ['first_name' => $value]))
        ->assertInvalid('first_name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid last name', function ($value) {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('users.update', $user),
            array_merge($user->toArray(), ['last_name' => $value]))
        ->assertInvalid('last_name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid email', function ($value) {
    User::factory()
        ->create(['email' => 'duplicate@email.com',]);

    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('users.update', $user),
            array_merge($user->toArray(), ['email' => $value]))
        ->assertInvalid('email');
})
    ->with([null, 1, 1.5, true, 'invalid-email', str_repeat('a', 255) . '@email.com', 'duplicate@email.com']);

it('requires a valid phone number', function ($value) {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('users.update', $user),
            array_merge($user->toArray(), ['phone_number' => $value]))
        ->assertInvalid('phone_number');
})
    ->with([null, 1, 1.5, true, 'invalid-phone', '020 7946 0958']);

it('requires a valid password', function ($value) {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('users.update', $user),
            array_merge($user->toArray(), [
                'password' => $value,
                'password_confirmation' => $value === 'not-matched' ? 'not-matched-other' : $value
            ]))
        ->assertInvalid('password');
})
    ->with([1, 1.5, true, 'short', str_repeat('a', 256), 'not-matched']);
