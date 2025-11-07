<?php

use App\Models\DashboardTile;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('requires authentication', function () {
    $dashboardTileData = DashboardTile::factory()->make()->toArray();

    post(route('dashboard-tiles.store'), $dashboardTileData)
        ->assertRedirect(route('sessions.create'));
});

it('can create a dashboard_tile', function () {
    $dashboardTileData = DashboardTile::factory()->make()->toArray();

    actingAs(User::factory()->create())
        ->post(route('dashboard-tiles.store'), $dashboardTileData);

    assertDatabaseHas(DashboardTile::class, $dashboardTileData);
});

it('redirects to the dashboard_tile index', function () {
    $dashboardTileData = DashboardTile::factory()->make()->toArray();

    actingAs(User::factory()->create())
        ->post(route('dashboard-tiles.store'), $dashboardTileData)
        ->assertRedirect(route('dashboard-tiles.index'))
        ->assertSessionHas([
            'status' => 'success',
            'message' => 'New dashboard tile has been created.'
        ]);
});

it('requires a valid page_id', function ($value) {
    $dashboardTileData = DashboardTile::factory()
        ->make(['page_id' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('dashboard-tiles.store'), $dashboardTileData)
        ->assertInvalid('page_id');
})
    ->with([1, 'invalid-input']);

it('requires a valid parent_dashboard_tile_id', function ($value) {
    $dashboardTileData = DashboardTile::factory()
        ->make([
            'id' => 1,
            'parent_dashboard_tile_id' => $value
        ])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('dashboard-tiles.store'), $dashboardTileData)
        ->assertInvalid('parent_dashboard_tile_id');
})
    ->with([2, 'test']);

it('requires a valid title', function ($value) {
    $dashboardTileData = DashboardTile::factory()
        ->make(['title' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('dashboard-tiles.store'), $dashboardTileData)
        ->assertInvalid('title');
})
    ->with([null, 1, 1.5, true, str_repeat('a', 256)]);


it('requires a valid sort_order', function ($value) {
    $dashboardTileData = DashboardTile::factory()
        ->make(['sort_order' => $value])
        ->toArray();

    actingAs(User::factory()->create())
        ->post(route('dashboard-tiles.store'), $dashboardTileData)
        ->assertInvalid('sort_order');
})
    ->with([null, -1, 1.5, 'test']);
