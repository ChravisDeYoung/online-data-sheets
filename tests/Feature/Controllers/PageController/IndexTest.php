<?php

use App\Models\Field;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('pages.index'))
        ->assertredirect(route('sessions.create'));
});

it('returns the index view', function () {
    actingAs(User::factory()->create())
        ->get(route('pages.index'))
        ->assertViewIs('pages.index');
});

it('shows sorted pages', function () {
    Page::factory()->create(['name' => 'Test Page 2']);
    Page::factory()->create(['name' => 'Test Page 1']);

    actingAs(User::factory()->create())
        ->get(route('pages.index'))
        ->assertSeeInOrder(['Test Page 1', 'Test Page 2']);
});

it('searches pages by name', function () {
    Page::factory()->create(['name' => 'test Page 1']);
    Page::factory()->create(['name' => 'TEST PAGE 2']);
    Page::factory()->create(['name' => 'FAILED 1']);

    actingAs(User::factory()->create())
        ->get(route('pages.index', ['search' => 'est']))
        ->assertSee(['test Page 1', 'TEST PAGE 2'])
        ->assertDontSee('FAILED 1');
});

it('loads fields', function () {
    $page = Page::factory()->create();
    Field::factory(5)->create(['page_id' => $page->id]);

    actingAs(User::factory()->create())
        ->get(route('pages.index'))
        ->assertSee('5 field(s)');
});
