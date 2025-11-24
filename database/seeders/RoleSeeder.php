<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrator']);

        foreach (Page::all() as $page) {
            Role::create(['name' => $page->slug, 'description' => "$page->name user"]);
        }
    }
}
