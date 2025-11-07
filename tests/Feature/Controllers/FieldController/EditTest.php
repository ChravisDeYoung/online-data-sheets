<?php

use App\Models\Field;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $field = Field::factory()->create();

    get(route('fields.edit', $field))
        ->assertredirect(route('sessions.create'));
});

it('returns the edit view', function () {
    $field = Field::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('fields.edit', $field))
        ->assertViewIs('fields.edit')
        ->assertViewHas('field', $field);
});
