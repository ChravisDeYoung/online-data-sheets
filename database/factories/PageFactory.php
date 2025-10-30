<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    public function definition()
    {
        $name = ucfirst($this->faker->word()) . ' Sheet';
        return [
            'name' => $name,
            'slug' => str_replace(' ', '-', strtolower($name)),
            'column_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
