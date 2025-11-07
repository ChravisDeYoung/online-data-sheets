<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires guest', function () {
    actingAs(User::factory()->create())
        ->get(route('sessions.create'))
        ->assertredirect(route('dashboards.index'));
});

it('returns the login view', function () {
    get(route('sessions.create'))
        ->assertViewIs('sessions.create');
});
