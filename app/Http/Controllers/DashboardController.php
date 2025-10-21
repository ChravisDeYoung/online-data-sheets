<?php

namespace App\Http\Controllers;

use App\Models\DashboardTile;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index', [
            'dashboardTiles' => DashboardTile::where('parent_dashboard_tile_id', null)
                ->orderBy('sort_order')
                ->get()
        ]);
    }

    public function show(int $dashboardTileId)
    {
        return view('dashboard.index', [
            'dashboardTiles' => DashboardTile::where('parent_dashboard_tile_id', $dashboardTileId)
                ->orderBy('sort_order')
                ->get()
        ]);
    }
}
