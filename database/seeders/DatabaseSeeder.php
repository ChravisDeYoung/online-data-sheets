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
        $users = User::factory(10)->create();

//        Page::factory(10)
//            ->has(Field::factory())
//            ->create();

//        $posts = Post::factory(10)->recycle($users)->create();

        // Create pages
        $safetyDataSheet = Page::create([
            'name' => 'Safety Data Sheet',
            'slug' => 'safety-data-sheet',
            'column_count' => 5,
        ]);

        $equipmentSheet = Page::create([
            'name' => 'Equipment Specification',
            'slug' => 'equipment-specification',
        ]);

        $processSheet = Page::create([
            'name' => 'Process Flow Sheet',
            'slug' => 'process-flow-sheet',
        ]);

        DashboardTile::create([
            'title' => 'Safety Sheets',
            'page_id' => $safetyDataSheet->id,
            'sort_order' => 1,
        ]);

        $dataTile = DashboardTile::create([
            'title' => 'Data Sheets',
            'sort_order' => 2,
        ]);

        DashboardTile::create([
            'title' => 'Equipment Specification',
            'sort_order' => 1,
            'page_id' => $equipmentSheet->id,
            'parent_dashboard_tile_id' => $dataTile->id,
        ]);

        DashboardTile::create([
            'title' => 'Process Flow Sheet',
            'sort_order' => 2,
            'page_id' => $processSheet->id,
            'parent_dashboard_tile_id' => $dataTile->id,
        ]);

        // Safety Data Sheet Fields
        Field::insert([
            // Product Identification
            ['page_id' => $safetyDataSheet->id, 'name' => 'Product Name', 'type' => Field::TYPE_TEXT, 'subsection' => 'Product Identification', 'subsection_sort_order' => 1, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1,3,5', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Chemical Formula', 'type' => Field::TYPE_TEXT, 'subsection' => 'Product Identification', 'subsection_sort_order' => 1, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1,3,5', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'CAS Number', 'type' => Field::TYPE_TEXT, 'subsection' => 'Product Identification', 'subsection_sort_order' => 1, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1,3,5', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Manufacturer', 'type' => Field::TYPE_TEXT, 'subsection' => 'Product Identification', 'subsection_sort_order' => 1, 'sort_order' => 4, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1,3,5', 'created_at' => now(), 'updated_at' => now()],

            // Hazard Identification
            ['page_id' => $safetyDataSheet->id, 'name' => 'Hazard Classification', 'type' => Field::TYPE_SELECT, 'subsection' => 'Hazard Identification', 'subsection_sort_order' => 2, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => 'Low,Medium,High', 'required_columns' => '2,4', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Signal Word', 'type' => Field::TYPE_SELECT, 'subsection' => 'Hazard Identification', 'subsection_sort_order' => 2, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => 'Warning,Danger', 'required_columns' => '2,4', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Hazard Statements', 'type' => Field::TYPE_TEXTAREA, 'subsection' => 'Hazard Identification', 'subsection_sort_order' => 2, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '2,4', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Precautionary Statements', 'type' => Field::TYPE_TEXTAREA, 'subsection' => 'Hazard Identification', 'subsection_sort_order' => 2, 'sort_order' => 4, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '2,4', 'created_at' => now(), 'updated_at' => now()],

            // Physical Properties
            ['page_id' => $safetyDataSheet->id, 'name' => 'Appearance', 'type' => Field::TYPE_TEXT, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Odor', 'type' => Field::TYPE_TEXT, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'pH', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 3, 'minimum' => 12.20, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Melting Point (°C)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 4, 'minimum' => 12.20, 'maximum' => 19.20, 'select_options' => null, 'required_columns' => '1,2,3,4,5', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Boiling Point (°C)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 5, 'minimum' => null, 'maximum' => 19.20, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Flash Point (°C)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 6, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Density (g/mL)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 7, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $safetyDataSheet->id, 'name' => 'Viscosity', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Physical & Chemical Properties', 'subsection_sort_order' => 3, 'sort_order' => 8, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],

            // Equipment Specification Fields
            ['page_id' => $equipmentSheet->id, 'name' => 'Equipment Tag', 'type' => Field::TYPE_TEXT, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Equipment Name', 'type' => Field::TYPE_TEXT, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Equipment Type', 'type' => Field::TYPE_SELECT, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => 'Metal,Wood', 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Manufacturer', 'type' => Field::TYPE_TEXT, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 4, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Model Number', 'type' => Field::TYPE_TEXT, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 5, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Serial Number', 'type' => Field::TYPE_TEXT, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 6, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Installation Date', 'type' => Field::TYPE_DATE, 'subsection' => 'General Information', 'subsection_sort_order' => 1, 'sort_order' => 7, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],

            // Operating Conditions
            ['page_id' => $equipmentSheet->id, 'name' => 'Design Pressure (psi)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Operating Conditions', 'subsection_sort_order' => 2, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Design Temperature (°C)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Operating Conditions', 'subsection_sort_order' => 2, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Operating Pressure (psi)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Operating Conditions', 'subsection_sort_order' => 2, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Operating Temperature (°C)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Operating Conditions', 'subsection_sort_order' => 2, 'sort_order' => 4, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Flow Rate (L/min)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Operating Conditions', 'subsection_sort_order' => 2, 'sort_order' => 5, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Power Rating (kW)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Operating Conditions', 'subsection_sort_order' => 2, 'sort_order' => 6, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],

            // Materials
            ['page_id' => $equipmentSheet->id, 'name' => 'Material of Construction', 'type' => Field::TYPE_TEXT, 'subsection' => 'Materials & Specifications', 'subsection_sort_order' => 3, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Corrosion Allowance (mm)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Materials & Specifications', 'subsection_sort_order' => 3, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $equipmentSheet->id, 'name' => 'Inspection Required', 'type' => Field::TYPE_CHECKBOX, 'subsection' => 'Materials & Specifications', 'subsection_sort_order' => 3, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],

            // Process Flow Sheet Fields
            ['page_id' => $processSheet->id, 'name' => 'Process Name', 'type' => Field::TYPE_TEXT, 'subsection' => 'Process Information', 'subsection_sort_order' => 1, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Process Unit', 'type' => Field::TYPE_TEXT, 'subsection' => 'Process Information', 'subsection_sort_order' => 1, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Stream Number', 'type' => Field::TYPE_TEXT, 'subsection' => 'Process Information', 'subsection_sort_order' => 1, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Stream Description', 'type' => Field::TYPE_TEXTAREA, 'subsection' => 'Process Information', 'subsection_sort_order' => 1, 'sort_order' => 4, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],

            // Stream Properties
            ['page_id' => $processSheet->id, 'name' => 'Mass Flow Rate (kg/hr)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Stream Properties', 'subsection_sort_order' => 2, 'sort_order' => 1, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Volumetric Flow Rate (m³/hr)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Stream Properties', 'subsection_sort_order' => 2, 'sort_order' => 2, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Temperature (°C)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Stream Properties', 'subsection_sort_order' => 2, 'sort_order' => 3, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Pressure (bar)', 'type' => Field::TYPE_NUMBER, 'subsection' => 'Stream Properties', 'subsection_sort_order' => 2, 'sort_order' => 4, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Composition', 'type' => Field::TYPE_TEXTAREA, 'subsection' => 'Stream Properties', 'subsection_sort_order' => 2, 'sort_order' => 5, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['page_id' => $processSheet->id, 'name' => 'Phase', 'type' => Field::TYPE_SELECT, 'subsection' => 'Stream Properties', 'subsection_sort_order' => 2, 'sort_order' => 6, 'minimum' => null, 'maximum' => null, 'select_options' => null, 'required_columns' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
