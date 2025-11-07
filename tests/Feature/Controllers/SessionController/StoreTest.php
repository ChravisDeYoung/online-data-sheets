<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\post;

it('requires guest', function () {
    actingAs(User::factory()->create())
        ->post(route('sessions.store'), [
            'email' => '',
            'password' => '',
        ])
        ->assertredirect(route('dashboards.index'));
});

it('can login', function () {
    $user = User::factory()->create(['password' => 'test']);

    post(route('sessions.store'), [
        'email' => $user->email,
        'password' => 'test',
    ]);

    assertAuthenticated();
});

it('redirects to the dashboards index', function () {
    $user = User::factory()->create(['password' => 'test']);

    post(route('sessions.store'), [
        'email' => $user->email,
        'password' => 'test',
    ])
        ->assertRedirect(route('dashboards.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'Welcome back!'
        ]);
});

it('requires a valid email', function ($value) {
    $user = User::factory()->create([
        'password' => 'test'
    ]);

    post(route('sessions.store'), [
        'email' => $value,
        'password' => 'test',
    ])
        ->assertInvalid('email');
})
    ->with([null, 'not-an-email', 'missing-at-sign.com', 'missing-domain@', 'fake@email.com']);

it('requires a valid password', function ($value) {
    $user = User::factory()->create([
        'password' => 'test'
    ]);

    post(route('sessions.store'), [
        'password' => $value,
    ])
        ->assertInvalid('email');
})
    ->with([null, 'test1']);


