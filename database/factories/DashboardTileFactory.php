<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DashboardTileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'page_id' => Page::factory(),
            'parent_dashboard_tile_id' => null,
            'title' => $this->faker->realText(15)->title(),
            'sort_order' => $this->faker->randomDigit()
            /*
             *
             *             $table->foreignId('page_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('parent_dashboard_tile_id')->nullable()->constrained('dashboard_tiles')->restrictOnDelete();
            $table->string('title');
            $table->integer('sort_order');
             */
        ];
    }
}
