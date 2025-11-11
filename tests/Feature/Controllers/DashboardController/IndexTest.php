<?php

use App\Models\DashboardTile;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('dashboards.index'))
        ->assertredirect(route('sessions.create'));
});

it('returns the index view', function () {
    actingAs(User::factory()->create())
        ->get(route('dashboards.index'))
        ->assertViewIs('dashboards.index');
});

it('loads dashboardTiles in order', function () {
    $orphanTile1 = DashboardTile::factory()->create(['title' => 'Tile 3', 'sort_order' => 3, 'parent_dashboard_tile_id' => null]);
    $orphanTile2 = DashboardTile::factory()->create(['title' => 'Tile 2', 'sort_order' => 2, 'parent_dashboard_tile_id' => null]);
    $parentTile = DashboardTile::factory()->create(['title' => 'Tile 1', 'sort_order' => 1, 'parent_dashboard_tile_id' => null]);
    $childTile = DashboardTile::factory()->create(['title' => 'Tile 4', 'sort_order' => 4, 'parent_dashboard_tile_id' => $parentTile->id]);

    actingAs(User::factory()->create())
        ->get(route('dashboards.index'))
        ->assertViewIs('dashboards.index')
        ->assertViewHas('dashboardTiles', fn($dashboardTiles) => $dashboardTiles->count() === 3)
        ->assertSeeInOrder([$parentTile->title, $orphanTile2->title, $orphanTile1->title])
        ->assertDontSee($childTile->title);
});
