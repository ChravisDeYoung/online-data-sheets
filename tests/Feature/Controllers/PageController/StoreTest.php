<?php

use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('requires authentication', function () {
    $pageData = Page::factory()->make()->toArray();

    post(route('pages.store'), $pageData)
        ->assertRedirect(route('sessions.create'));
});

it('can create a page', function () {
    $pageData = Page::factory()->make()->toArray();

    actingAs(User::factory()->create())
        ->post(route('pages.store'), $pageData);

    assertDatabaseHas(Page::class, $pageData);
});

it('redirects to the pages index', function () {
    $pageData = Page::factory()->make()->toArray();

    actingAs(User::factory()->create())
        ->post(route('pages.store'), $pageData)
        ->assertRedirect(route('pages.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'New page has been created.'
        ]);
});

it('requires a valid name', function ($value) {
    $pageData = Page::factory()
        ->make(['name' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('pages.store'), $pageData)
        ->assertInvalid('name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid slug', function ($value) {
    Page::factory()
        ->create(['slug' => 'duplicate-slug']);

    $pageData = Page::factory()
        ->make(['slug' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('pages.store'), $pageData)
        ->assertInvalid('slug');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256), 'duplicate-slug']);

it('requires a valid column_count', function ($value) {
    $pageData = Page::factory()
        ->make(['column_count' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('pages.store'), $pageData)
        ->assertInvalid('column_count');
})
    ->with([null, 0, 13, 6.1, 'test string']);
