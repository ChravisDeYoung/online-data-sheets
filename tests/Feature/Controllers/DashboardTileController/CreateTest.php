<?php

use App\Models\DashboardTile;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('dashboard-tiles.create'))
        ->assertredirect(route('login'));
});

it('returns the create view', function () {
    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.create'))
        ->assertViewIs('dashboard_tiles.create');
});

it('loads pages', function () {
    $pageVisibleCount = 3;
    Page::factory($pageVisibleCount)->create();

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.create'))
        ->assertViewIs('dashboard_tiles.create')
        ->assertViewHas('pages', fn($pages) => $pages->count() === $pageVisibleCount);
});

it('loads dashboardTiles', function () {
    $dashboardVisibleCount = 2;
    DashboardTile::factory($dashboardVisibleCount)->create(['page_id' => null]);
    DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.create'))
        ->assertViewIs('dashboard_tiles.create')
        ->assertViewHas('dashboardTiles', fn($pages) => $pages->count() === $dashboardVisibleCount);
});
