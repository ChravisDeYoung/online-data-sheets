<?php

use App\Models\Field;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('fields.index'))
        ->assertredirect(route('login'));
});

it('returns the index view', function () {
    actingAs(User::factory()->create())
        ->get(route('fields.index'))
        ->assertViewIs('fields.index');
});

it('shows sorted fields', function () {
    Field::factory()->create(['name' => 'Test Field 3', 'sort_order' => 1, 'subsection_sort_order' => 2]);
    Field::factory()->create(['name' => 'Test Field 2', 'sort_order' => 2, 'subsection_sort_order' => 1]);
    Field::factory()->create(['name' => 'Test Field 1', 'sort_order' => 1, 'subsection_sort_order' => 1]);

    actingAs(User::factory()->create())
        ->get(route('fields.index'))
        ->assertSeeInOrder(['Test Field 1', 'Test Field 2', 'Test Field 3']);
});

it('searches fields by name', function () {
    Field::factory()->create(['name' => 'test Field 1']);
    Field::factory()->create(['name' => 'TEST FIELD 2']);
    Field::factory()->create(['name' => 'FAILED 1']);

    actingAs(User::factory()->create())
        ->get(route('fields.index', ['search' => 'est']))
        ->assertSee(['test Field 1', 'TEST FIELD 2'])
        ->assertDontSee('FAILED 1');
});

it('searches fields by subsection', function () {
    Field::factory()->create(['subsection' => 'test Subsection 1']);
    Field::factory()->create(['subsection' => 'TEST SUBSECTION 2']);
    Field::factory()->create(['subsection' => 'FAILED 1']);

    actingAs(User::factory()->create())
        ->get(route('fields.index', ['search' => 'est']))
        ->assertSee(['test Subsection 1', 'TEST SUBSECTION 2'])
        ->assertDontSee('FAILED 1');
});

it('searches fields by page name', function () {
    $page1 = Page::factory()->create(['name' => 'Test Page 1']);
    Field::factory()->create(['name' => 'Field 1', 'page_id' => $page1->id]);
    Field::factory()->create(['name' => 'Field 2', 'page_id' => $page1->id]);

    $page2 = Page::factory()->create(['name' => 'Fail Page 2']);
    Field::factory()->create(['name' => 'Field 3', 'page_id' => $page2->id]);

    actingAs(User::factory()->create())
        ->get(route('fields.index', ['search' => 'PAGE 1']))
        ->assertSee(['Field 1', 'Field 2'])
        ->assertDontSee('Field 3');
});

it('loads page', function () {
    $page = Page::factory()->create(['name' => 'Test Page 1']);
    Field::factory()->create(['page_id' => $page->id]);

    actingAs(User::factory()->create())
        ->get(route('fields.index'))
        ->assertSee('Test Page 1');
});
