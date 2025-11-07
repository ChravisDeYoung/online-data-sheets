<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $user = User::factory()->create();

    get(route('users.edit', $user))
        ->assertredirect(route('sessions.create'));
});

it('returns the edit view', function () {
    $user = User::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('users.edit', $user))
        ->assertViewIs('users.edit')
        ->assertViewHas('user', $user);
});
