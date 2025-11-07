<?php

use App\Models\DashboardTile;
use App\Models\Field;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('requires authentication', function () {
    get(route('dashboard-tiles.index'))
        ->assertredirect(route('sessions.create'));
});

it('returns the index view', function () {
    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.index'))
        ->assertViewIs('dashboard_tiles.index');
});

it('shows sorted dashboard_tiles', function () {
    DashboardTile::factory()->create(['title' => 'Tile 2', 'sort_order' => 2]);
    DashboardTile::factory()->create(['title' => 'Tile 1', 'sort_order' => 1]);

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.index'))
        ->assertSeeInOrder(['Tile 1', 'Tile 2']);
});

it('searches dashboard_tiles by name', function () {
    DashboardTile::factory()->create(['title' => 'Tile 1']);
    DashboardTile::factory()->create(['title' => 'TILE 2']);
    DashboardTile::factory()->create(['title' => 'Not Found']);

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.index', ['search' => 'ile']))
        ->assertSee(['Tile 1', 'TILE 2'])
        ->assertDontSee('Not Found');
});

it('loads with page', function () {
    $page = Page::factory()->create(['name' => 'Test Page 1']);
    DashboardTile::factory()->create(['page_id' => $page->id]);

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.index'))
        ->assertSee('Test Page 1');
});

it('loads with parent_dashboard_tile', function () {
    $parentDashboard = DashboardTile::factory()->create(['title' => 'Parent Dashboard']);
    DashboardTile::factory()->create(['parent_dashboard_tile_id' => $parentDashboard->id]);

    actingAs(User::factory()->create())
        ->get(route('dashboard-tiles.index'))
        ->assertSee('Parent Dashboard');
});
