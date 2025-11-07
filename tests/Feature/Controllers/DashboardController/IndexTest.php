<?php

use App\Models\DashboardTile;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('dashboards.index'))
        ->assertredirect(route('login'));
});

it('returns the index view', function () {
    actingAs(User::factory()->create())
        ->get(route('dashboards.index'))
        ->assertViewIs('dashboards.index');
});

it('loads dashboardTiles in order', function () {
    DashboardTile::factory()->create(['title' => 'Tile 3', 'sort_order' => 3, 'parent_dashboard_tile_id' => null]);
    DashboardTile::factory()->create(['title' => 'Tile 2', 'sort_order' => 2, 'parent_dashboard_tile_id' => null]);
    $tile = DashboardTile::factory()->create(['title' => 'Tile 1', 'sort_order' => 1, 'parent_dashboard_tile_id' => null]);
    DashboardTile::factory()->create(['title' => 'Tile 4', 'sort_order' => 4, 'parent_dashboard_tile_id' => $tile->id]);

    actingAs(User::factory()->create())
        ->get(route('dashboards.index'))
        ->assertViewIs('dashboards.index')
        ->assertViewHas('dashboardTiles', fn($dashboardTiles) => $dashboardTiles->count() === 3)
        ->assertSeeInOrder(['Tile 1', 'Tile 2', 'Tile 3'])
        ->assertDontSee('Tile 4');
});
