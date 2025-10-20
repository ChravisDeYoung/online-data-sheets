<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardTileRequest;
use App\Http\Requests\UpdateDashboardTileRequest;
use App\Models\DashboardTile;
use Illuminate\View\View;

class DashboardTileController extends Controller
{
    public function index(): View
    {
        return view('dashboard_tile.index', ['dashboardTiles' => DashboardTile::orderBy('sort_order')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDashboardTileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDashboardTileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\DashboardTile $dashboardTile
     * @return \Illuminate\Http\Response
     */
    public function show(DashboardTile $dashboardTile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\DashboardTile $dashboardTile
     * @return \Illuminate\Http\Response
     */
    public function edit(DashboardTile $dashboardTile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateDashboardTileRequest $request
     * @param \App\Models\DashboardTile $dashboardTile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDashboardTileRequest $request, DashboardTile $dashboardTile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\DashboardTile $dashboardTile
     * @return \Illuminate\Http\Response
     */
    public function destroy(DashboardTile $dashboardTile)
    {
        //
    }
}
