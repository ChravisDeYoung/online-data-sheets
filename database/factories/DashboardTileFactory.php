<?php

namespace Database\Factories;

use App\Models\DashboardTile;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for creating DashboardTile model instances.
 *
 * @extends Factory<DashboardTile>
 */
class DashboardTileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_id' => Page::factory(),
            'parent_dashboard_tile_id' => null,
            'title' => ucwords($this->faker->realText(15)),
            'sort_order' => $this->faker->randomDigit()
        ];
    }
}
