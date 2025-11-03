<?php

use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patch;

it('requires authentication', function () {
    $page = Page::factory()->create();

    patch(
        route('pages.update', $page),
        ['name' => 'Updated Name'])
        ->assertredirect('/login');
});

it('can update a page', function () {
    $page = Page::factory()->create([
        'name' => 'Test Page 1',
        'slug' => 'test-page-1',
        'column_count' => 3,
    ]);

    $updatedPageData = [
        'name' => 'Updated Test Page 1',
        'slug' => 'updated-test-page-1',
        'column_count' => 4,
    ];

    actingAs(User::factory()->create())
        ->patch(route('pages.update', $page), $updatedPageData);

    assertDatabaseHas(Page::class, $updatedPageData);
});

it('redirects to the pages index', function () {
    $page = Page::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('pages.update', $page),
            array_merge($page->toArray(), ['slug' => 'updated-slug']))
        ->assertRedirect(route('pages.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'Page updated'
        ]);
});

it('requires a valid name', function ($value) {
    $page = Page::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('pages.update', $page),
            array_merge($page->toArray(), ['name' => $value]))
        ->assertInvalid('name');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid slug', function ($value) {
    Page::factory()
        ->create(['slug' => 'duplicate-slug']);

    $page = Page::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('pages.update', $page),
            array_merge($page->toArray(), ['slug' => $value]))
        ->assertInvalid('slug');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256), 'duplicate-slug']);

it('requires a valid column_count', function ($value) {
    $page = Page::factory()->create();

    actingAs(User::factory()->create())
        ->post(
            route('pages.store', $page),
            array_merge($page->toArray(), ['column_count' => $value]))
        ->assertInvalid('column_count');
})
    ->with([null, 0, 13, 6.1, 'test string']);
