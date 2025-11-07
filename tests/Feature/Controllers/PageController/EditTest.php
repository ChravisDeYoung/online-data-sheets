<?php

use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $page = Page::factory()->create();

    get(route('pages.edit', $page))
        ->assertredirect(route('sessions.create'));
});

it('returns the edit view', function () {
    $page = Page::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('pages.edit', $page))
        ->assertViewIs('pages.edit')
        ->assertViewHas('page', $page);
});
