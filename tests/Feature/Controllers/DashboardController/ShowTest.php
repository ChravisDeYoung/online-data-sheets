<?php

use App\Models\DashboardTile;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    $dashboardTile = DashboardTile::factory()->create();

    get(route('dashboards.show', $dashboardTile->id))
        ->assertredirect(route('sessions.create'));
});

it('returns the index view', function () {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->get(route('dashboards.index', $dashboardTile->id))
        ->assertViewIs('dashboards.index');
});

it('loads dashboardTiles in order by parent', function () {
    $parentTile = DashboardTile::factory()->create(['title' => 'Parent Tile']);
    DashboardTile::factory()->create(['title' => 'Tile 3', 'sort_order' => 3, 'parent_dashboard_tile_id' => $parentTile->id]);
    DashboardTile::factory()->create(['title' => 'Tile 2', 'sort_order' => 2, 'parent_dashboard_tile_id' => $parentTile->id]);
    DashboardTile::factory()->create(['title' => 'Tile 1', 'sort_order' => 1, 'parent_dashboard_tile_id' => $parentTile->id]);
    DashboardTile::factory()->create(['title' => 'Tile 4', 'sort_order' => 4, 'parent_dashboard_tile_id' => null]);

    actingAs(User::factory()->create())
        ->get(route('dashboards.show', $parentTile->id))
        ->assertViewIs('dashboards.index')
        ->assertViewHas('dashboardTiles', fn($dashboardTiles) => $dashboardTiles->count() === 3)
        ->assertSeeInOrder(['Tile 1', 'Tile 2', 'Tile 3'])
        ->assertDontSee(['Parent Tile', 'Tile 4']);
});
