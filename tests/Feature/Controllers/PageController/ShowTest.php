<?php

use App\Models\Field;
use App\Models\FieldData;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $page = Page::factory()->create();

    get(route('pages.show', $page))
        ->assertredirect(route('sessions.create'));
});

it('returns the show view', function () {
    $page = Page::factory()->create();

    $now = Carbon::now();
    Carbon::setTestNow($now);

    actingAs(User::factory()->create())
        ->get(route('pages.show', $page->slug))
        ->assertViewIs('pages.show')
        ->assertViewHas('page', $page)
        ->assertViewHas('pageDate', $now);
});

it('shows a default date', function ($value) {
    $page = Page::factory()->create();

    $now = Carbon::now();
    Carbon::setTestNow($now);

    actingAs(User::factory()->create())
        ->get(route('pages.show', [$page, 'date' => $value]))
        ->assertViewHas('pageDate', $now);
})
    ->with([null, 'invalid-date']);

it('parses passed date', function () {
    $page = Page::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('pages.show', [$page, 'date' => '2025-02-03']))
        ->assertViewHas('pageDate', Carbon::create(2025, 2, 3));
});

it('displays fields in correct order', function () {
    $page = Page::factory()->create();
    Field::factory()->create(['page_id' => $page->id, 'name' => 'Field 3', 'subsection' => 'Subsection 2', 'subsection_sort_order' => 2, 'sort_order' => 2]);
    Field::factory()->create(['page_id' => $page->id, 'name' => 'Field 2', 'subsection' => 'Subsection 2', 'subsection_sort_order' => 2, 'sort_order' => 1]);
    Field::factory()->create(['page_id' => $page->id, 'name' => 'Field 1', 'subsection' => 'Subsection 1', 'subsection_sort_order' => 1]);

    actingAs(User::factory()->create())
        ->get(route('pages.show', $page))
        ->assertSeeInOrder([
            'Subsection 1',
            'Subsection 2',
        ])
        ->assertSeeInOrder([
            'Field 1',
            'Field 2',
            'Field 3',
        ]);
});

