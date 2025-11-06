<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\DashboardTile;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
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
        return view('dashboard_tile.index', [
            'dashboardTiles' => DashboardTile::with('page')
                ->with('parentDashboardTile')
                ->search(request('search'))
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
        return view('dashboard_tile.create', [
            'pages' => Page::all(),
            'dashboardTiles' => DashboardTile::whereNull('page_id')->get(),
        ]);
    }

    /**
     * Store a newly created dashboard tile in storage.
     *
     * @return RedirectResponse The redirect response after storing the dashboard tile.
     */
    public function store(): RedirectResponse
    {
        $attributes = $this->validateDashboardTile();

        DashboardTile::create($attributes);

        return redirect()
            ->route('dashboard-tiles.index')
            ->with([
                'status' => 'success',
                'message' => 'New dashboard tile has been created.'
            ]);
    }

    /**
     * Display the form to edit the specified dashboard tile.
     * @param DashboardTile $dashboardTile The dashboard tile to be edited.
     * @return View The view for editing the dashboard tile.
     */
    public function edit(DashboardTile $dashboardTile): View
    {
        return view('dashboard_tile.edit', [
            'dashboardTile' => $dashboardTile,
            'pages' => $dashboardTile->childrenDashboardTiles()->exists() ? [] : Page::all(),
            'dashboardTiles' => DashboardTile::whereNull('page_id')
                ->where('id', '!=', $dashboardTile->id)
                ->get(),
        ]);
    }

    /**
     * Update the specified dashboard tile in storage.
     *
     * @param DashboardTile $dashboardTile The dashboard tile to be updated.
     * @return RedirectResponse The redirect response after updating the dashboard tile.
     */
    public function update(DashboardTile $dashboardTile)
    {
        $validated = $this->validateDashboardTile($dashboardTile);

        $dashboardTile->update($validated);

        return redirect()
            ->route('dashboard-tiles.index')
            ->with([
                'status' => 'success',
                'message' => 'Dashboard tile updated.'
            ]);
    }

    /**
     * Validate the request data for creating or updating a dashboard tile.
     *
     * @param DashboardTile|null $dashboardTile The dashboard tile instance being validated, or null if a new instance is being created.
     * @return array The validated data.
     */
    private function validateDashboardTile(?DashboardTile $dashboardTile = null): array
    {
        if (!$dashboardTile) {
            $dashboardTile = new DashboardTile();
        }

        return request()->validate([
            'page_id' => [
                'nullable',
                'exists:pages,id',
                function ($attribute, $value, $fail) use ($dashboardTile) {
                    if ($value && $dashboardTile->childrenDashboardTiles()->exists()) {
                        $fail('Cannot assign a page to a tile that has children.');
                    }
                },
            ],
            'parent_dashboard_tile_id' => [
                'nullable',
                // this is so that the parent dashboard tile goes to a sub dashboard instead of a page
                Rule::exists('dashboard_tiles', 'id')->where(function ($query) {
                    return $query->whereNull('page_id');
                }),
                'different:id'
            ],
            'title' => 'required|max:255',
            'sort_order' => 'required|integer|min:0',
        ]);
    }
}
