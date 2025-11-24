<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Page::create(['name' => 'Flow Data', 'slug' => 'flow-data', 'column_count' => 5]);
        Page::create(['name' => 'Safety Sheet', 'slug' => 'safety-sheet', 'column_count' => 3]);
        Page::create(['name' => 'Fermentation Data', 'slug' => 'fermentation-data', 'column_count' => 10]);
        Page::create(['name' => 'Lab Checklist', 'slug' => 'lab-checklist', 'column_count' => 2]);
        Page::create(['name' => 'Field Checklist', 'slug' => 'field-checklist', 'column_count' => 2]);
    }
}
