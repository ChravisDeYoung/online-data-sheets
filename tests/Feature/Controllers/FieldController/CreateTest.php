<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('fields.create'))
        ->assertredirect(route('login'));
});

it('returns the create view', function () {
    actingAs(User::factory()->create())
        ->get(route('fields.create'))
        ->assertViewIs('fields.create');
});
