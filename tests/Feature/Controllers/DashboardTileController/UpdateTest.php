<?php

use App\Models\DashboardTile;
use App\Models\Page;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\patch;

it('requires authentication', function () {
    $dashboardTile = DashboardTile::factory()->create();

    patch(
        route('dashboard-tiles.update', $dashboardTile),
        array_merge($dashboardTile->toArray(), ['title' => 'Updated Title']))
        ->assertRedirect(route('sessions.create'));
});

it('can update a dashboard_file', function () {
    $dashboardTile = DashboardTile::factory()->create([
        'page_id' => Page::factory()->create()->id,
        'parent_dashboard_tile_id' => null,
        'title' => 'Test Tile 1',
        'sort_order' => 1,
    ]);

    $dashboardTile2 = DashboardTile::factory()->create(['page_id' => null]);
    $updatedDashboardTileData = [
        'page_id' => Page::factory()->create()->id,
        'parent_dashboard_tile_id' => DashboardTile::factory()->create(['page_id' => null])->id,
        'title' => 'Test Tile 2',
        'sort_order' => 2,
    ];

    actingAs(User::factory()->create())
        ->patch(
            route('dashboard-tiles.update', $dashboardTile),
            $updatedDashboardTileData);

    assertDatabaseHas(DashboardTile::class, $updatedDashboardTileData);
});

it('redirects to the dashboard_tile index', function () {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('dashboard-tiles.update', $dashboardTile),
            array_merge($dashboardTile->toArray(), ['title' => 'Updated Title']))
        ->assertRedirect(route('dashboard-tiles.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'Dashboard tile updated.'
        ]);
});

it('requires a valid page_id', function ($value) {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('dashboard-tiles.update', $dashboardTile),
            array_merge($dashboardTile->toArray(), ['page_id' => $value]))
        ->assertInvalid('page_id');
})
    ->with([100, 'invalid-input']);

it('requires a valid parent_dashboard_tile_id', function ($value) {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('dashboard-tiles.update', $dashboardTile),
            array_merge($dashboardTile->toArray(), ['parent_dashboard_tile_id' => $value]))
        ->assertInvalid('parent_dashboard_tile_id');
})
    ->with([2, 'invalid-input']);

it('requires a valid title', function ($value) {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('dashboard-tiles.update', $dashboardTile),
            array_merge($dashboardTile->toArray(), ['title' => $value]))
        ->assertInvalid('title');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);

it('requires a valid sort_order', function ($value) {
    $dashboardTile = DashboardTile::factory()->create();

    actingAs(User::factory()->create())
        ->patch(
            route('dashboard-tiles.update', $dashboardTile),
            array_merge($dashboardTile->toArray(), ['sort_order' => $value]))
        ->assertInvalid('sort_order');
})
    ->with([null, -1, 1.5, 'test']);
