<?php

namespace Database\Seeders;

use App\Models\DashboardTile;
use App\Models\Field;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'first_name' => 'Travis',
            'last_name' => 'De Jong',
            'email' => 'travis.dejong@eventconnect.io',
        ]);
        User::factory(10)->create();

        $page = Page::factory()->create([
            'name' => 'Sample Data Sheet',
            'slug' => 'sample-data-sheet',
        ]);

        Field::factory()->create([
            'page_id' => $page->id,
            'name' => 'Initials',
            'type' => Field::TYPE_TEXT,
            'subsection' => 'Operator',
            'subsection_sort_order' => 1,
            'sort_order' => 1,
        ]);

        Field::factory()->create([
            'page_id' => $page->id,
            'name' => 'pH',
            'type' => Field::TYPE_NUMBER,
            'subsection' => 'Data',
            'subsection_sort_order' => 2,
            'sort_order' => 1,
        ]);

        Field::factory()->create([
            'page_id' => $page->id,
            'name' => 'Fructose',
            'type' => Field::TYPE_NUMBER,
            'subsection' => 'Data',
            'subsection_sort_order' => 2,
            'sort_order' => 2,
        ]);

        Field::factory()->create([
            'page_id' => $page->id,
            'name' => 'Pass/Fail',
            'type' => Field::TYPE_SELECT,
            'subsection' => 'Data',
            'subsection_sort_order' => 2,
            'sort_order' => 3,
        ]);

        DashboardTile::factory()->create([
            'page_id' => $page->id,
            'sort_order' => 1,
            'title' => 'Sample Data Sheet',
            'parent_dashboard_tile_id' => null,
        ]);
    }
}
