<?php

use App\Models\DashboardTile;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $dashboardTile = DashboardTile::factory()->create();

    get(route('dashboard-tiles.edit', $dashboardTile))
        ->assertredirect(route('login'));
});

it('returns the edit view', function () {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.edit', $dashboardTile))
        ->assertViewIs('dashboard_tiles.edit')
        ->assertViewHas('dashboardTile', $dashboardTile);
});

it('loads pages when it\'s not a parent', function () {
    $dashboardTile = DashboardTile::factory()->create(['page_id' => null]);
    $pageVisibleCount = 2;
    Page::factory($pageVisibleCount)->create();

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.edit', $dashboardTile))
        ->assertViewIs('dashboard_tiles.edit')
        ->assertViewHas('pages', fn($pages) => $pages->count() === $pageVisibleCount);
});

it('doesn\'t load pages when it\'s a parent', function () {
    $dashboardTile = DashboardTile::factory()->create(['page_id' => null]);
    DashboardTile::factory()->create(['parent_dashboard_tile_id' => $dashboardTile->id]);
    Page::factory(3)->create();

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.edit', $dashboardTile))
        ->assertViewIs('dashboard_tiles.edit')
        ->assertViewHas('pages', fn($pages) => $pages->count() === 0);
});

it('loads dashboardTiles', function () {
    $dashboardTile = DashboardTile::factory()->create(['page_id' => null]);
    DashboardTile::factory()->create(['page_id' => null]); // should be visible
    DashboardTile::factory()->create(); // shouldn't be visible

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.edit', $dashboardTile))
        ->assertViewIs('dashboard_tiles.edit')
        ->assertViewHas('dashboardTiles', fn($pages) => $pages->count() === 1);
});
