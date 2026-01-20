<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DashboardTileRequest;
use App\Models\DashboardTile;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controller responsible for managing dashboard tiles in the application.
 */
class DashboardTileController extends Controller
{
    /**
     * Display a listing of the dashboard tiles.
     *
     * @return View The view for displaying the dashboard tiles.
     */
    public function index(): View
    {
        return view('dashboard_tiles.index', [
            'dashboardTiles' => DashboardTile::select('id', 'title', 'page_id', 'parent_dashboard_tile_id')
                ->with('page:id,name,slug')
                ->with('parentDashboardTile:id,title')
                ->search(request('search'))
                ->orderBy('sort_order')
                ->paginate(10)
        ]);
    }

    /**
     * Display the form to create a new dashboard tile.
     *
     * @return View The view for creating a new dashboard tile.
     */
    public function create(): View
    {
        return view('dashboard_tiles.create', [
            'pages' => Page::select('id', 'name')
                ->get(),
            'dashboardTiles' => DashboardTile::select('id', 'title')
                ->whereNull('page_id')
                ->get(),
        ]);
    }

    /**
     * Store a newly created dashboard tile in storage.
     *
     * @param DashboardTileRequest $request The request object containing the dashboard tile data.
     * @return RedirectResponse The redirect response after storing the dashboard tile.
     */
    public function store(DashboardTileRequest $request): RedirectResponse
    {
        DashboardTile::create($request->validated());

        return redirect()
            ->route('dashboard-tiles.index')
            ->with([
                'status' => 'success',
                'message' => 'New dashboard tile has been created.'
            ]);
    }

    /**
     * Display the form to edit the specified dashboard tile.
     *
     * @param DashboardTile $dashboardTile The dashboard tile to be edited.
     * @return View The view for editing the dashboard tile.
     */
    public function edit(DashboardTile $dashboardTile): View
    {
        return view('dashboard_tiles.edit', [
            'dashboardTile' => $dashboardTile,
            'pages' => $dashboardTile->childrenDashboardTiles()->exists()
                ? collect([])
                : Page::select('id', 'name')
                    ->get(),
            'dashboardTiles' => DashboardTile::select('id', 'title')
                ->whereNull('page_id')
                ->where('id', '!=', $dashboardTile->id)
                ->get(),
        ]);
    }

    /**
     * Update the specified dashboard tile in storage.
     *
     * @param DashboardTileRequest $request The request object containing the updated dashboard tile data.
     * @param DashboardTile $dashboardTile The dashboard tile to be updated.
     * @return RedirectResponse The redirect response after updating the dashboard tile.
     */
    public function update(DashboardTileRequest $request, DashboardTile $dashboardTile): RedirectResponse
    {
        $dashboardTile->update($request->validated());

        return redirect()
            ->route('dashboard-tiles.index')
            ->with([
                'status' => 'success',
                'message' => 'Dashboard tile updated.'
            ]);
    }
}
