<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\post;

it('requires authentication', function () {
    post(route('sessions.destroy'))
        ->assertredirect(route('sessions.create'));
});

it('logs user out', function () {
    actingAs(User::factory()->create())
        ->post(route('sessions.destroy'));

    assertGuest();
});

it('redirects to the login page', function () {
    actingAs(User::factory()->create())
        ->post(route('sessions.destroy'))
        ->assertRedirect(route('sessions.create'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'Goodbye!'
        ]);;
});
