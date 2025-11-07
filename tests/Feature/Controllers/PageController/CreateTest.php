<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('pages.create'))
        ->assertredirect(route('sessions.create'));
});

it('returns the create view', function () {
    actingAs(User::factory()->create())
        ->get(route('pages.create'))
        ->assertViewIs('pages.create');
});
