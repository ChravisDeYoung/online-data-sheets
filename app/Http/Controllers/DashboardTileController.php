<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardTileRequest;
use App\Http\Requests\UpdateDashboardTileRequest;
use App\Models\DashboardTile;
use App\Models\Page;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardTileController extends Controller
{
    public function index(): View
    {
        return view('dashboard_tile.index', [
            'dashboardTiles' => DashboardTile::with('page')
                ->with('parentDashboardTile')
                ->search(request('search'))
                ->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('dashboard_tile.create', [
            'pages' => Page::all(),
            'dashboardTiles' => DashboardTile::whereNull('page_id')->get(),
        ]);
    }

    public function store()
    {
        $attributes = $this->validateDashboardTile();

        DashboardTile::create($attributes);

        return redirect('/dashboard-tiles')
            ->with('success', 'New dashboard tile has been created.');
    }

    public function edit(DashboardTile $dashboardTile)
    {
        return view('dashboard_tile.edit', [
            'dashboardTile' => $dashboardTile,
            'pages' => $dashboardTile->childrenDashboardTiles()->exists() ? [] : Page::all(),
            'dashboardTiles' => DashboardTile::whereNull('page_id')
                ->where('id', '!=', $dashboardTile->id)
                ->get(),
        ]);
    }

    public function update(DashboardTile $dashboardTile)
    {
        $validated = $this->validateDashboardTile($dashboardTile);

        $dashboardTile->update($validated);

        return redirect()
            ->route('dashboard-tiles.index')
            ->with('success', 'Dashboard tile updated');
    }

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
