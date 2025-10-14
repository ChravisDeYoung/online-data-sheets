<?php

namespace Database\Seeders;

use App\Models\Field;
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
        User::factory(10)->create();

        Field::factory()->create([
            'name' => 'Initials',
            'type' => Field::TYPE_TEXT,
            'subreport' => 'Sample Data Sheet',
            'subsection' => 'Operator',
            'subsection_sort_order' => 1,
            'sort_order' => 1,
        ]);

        Field::factory()->create([
            'name' => 'pH',
            'type' => Field::TYPE_NUMBER,
            'subreport' => 'Sample Data Sheet',
            'subsection' => 'Data',
            'subsection_sort_order' => 2,
            'sort_order' => 1,
        ]);

        Field::factory()->create([
            'name' => 'Fructose',
            'type' => Field::TYPE_NUMBER,
            'subreport' => 'Sample Data Sheet',
            'subsection' => 'Data',
            'subsection_sort_order' => 2,
            'sort_order' => 2,
        ]);

        Field::factory()->create([
            'name' => 'Pass/Fail',
            'type' => Field::TYPE_SELECT,
            'subreport' => 'Sample Data Sheet',
            'subsection' => 'Data',
            'subsection_sort_order' => 2,
            'sort_order' => 3,
        ]);
    }
}
