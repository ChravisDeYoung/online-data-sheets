<?php

namespace Database\Seeders;

use App\Models\DashboardTile;
use App\Models\Page;
use Illuminate\Database\Seeder;

class DashboardTileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $checklistsParentTile = DashboardTile::create([
            'title' => 'Checklists',
            'page_id' => null,
            'parent_dashboard_tile_id' => null,
            'sort_order' => 2
        ]);

        $pages = Page::all();
        for ($i = 0; $i < $pages->count(); $i++) {
            $dashboardTile = DashboardTile::make([
                'title' => $pages[$i]->name,
                'page_id' => $pages[$i]->id,
                'parent_dashboard_tile_id' => null,
                'sort_order' => $i + 1
            ]);

            if (str_contains(strtolower($pages[$i]->name), 'checklist')) {
                $dashboardTile['parent_dashboard_tile_id'] = $checklistsParentTile->id;
            }

            $dashboardTile->save();
        }
    }
}
