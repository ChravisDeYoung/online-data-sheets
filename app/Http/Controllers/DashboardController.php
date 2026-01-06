<?php

namespace App\Http\Controllers;

use App\Models\DashboardTile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller responsible for managing dashboards.
 */
class DashboardController extends Controller
{
    /**
     * Display a listing of the top-level dashboard tiles.
     *
     * @return View The view for displaying the dashboard tiles.
     */
    public function index(): View
    {
        $roles = Auth::user()->roles->pluck('name')->toArray();

        return view('dashboards.index', [
            'dashboardTiles' => DashboardTile::select('id', 'title', 'page_id')
                ->with('page:id,slug')
                ->where('parent_dashboard_tile_id', null)
                ->whereHas('page', function ($query) use ($roles) {
                    if (!in_array('admin', $roles, true)) {
                        $query->whereIn('slug', $roles);
                    }
                })
                ->orWhere('page_id', null)
                ->orderBy('sort_order')
                ->get()
        ]);
    }

    /**
     * Display the dashboard tiles for a specific dashboard tile.
     *
     * @param int $dashboardTileId The ID of the dashboard tile.
     * @return View The view for displaying the dashboard tiles.
     */
    public function show(int $dashboardTileId): View
    {
        if (!DashboardTile::find($dashboardTileId)) {
            abort(404, 'Dashboard tile not found.');
        }

        $roles = Auth::user()->roles->pluck('name')->toArray();

        return view('dashboards.index', [
            'dashboardTiles' => DashboardTile::select('id', 'title', 'page_id')
                ->with('page:id,slug')
                ->where('parent_dashboard_tile_id', $dashboardTileId)
                ->where(function ($query) use ($roles) {
                    $query->whereHas('page', function ($query) use ($roles) {
                        if (!in_array('admin', $roles, true)) {
                            $query->whereIn('slug', $roles);
                        }
                    })
                        ->orWhere('page_id', null);
                })
                ->orderBy('sort_order')
                ->get()
        ]);
    }
}
