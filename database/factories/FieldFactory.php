<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for creating Field model instances.
 *
 * @extends Factory<Field>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.'
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(array_keys(Field::getTypes()));

        $minimum = null;
        $maximum = null;
        if ($type === Field::TYPE_NUMBER) {
            $minimum = $this->faker->randomElement([
                $this->faker->randomFloat(2, 0, 100),
                null,
            ]);

            $maximum = $this->faker->randomElement([
                $this->faker->randomFloat(2, $minimum ?? 0, 100),
            ]);
        }

        $selectOptions = null;
        if ($type === Field::TYPE_SELECT) {
            $options = $this->faker->randomElements($this->faker->words(10));
            $selectOptions = implode(',', $options);
        }

        return [
            'page_id' => Page::factory(),
            'name' => ucfirst($this->faker->word()),
            'type' => $type,
            'subsection' => ucfirst($this->faker->word()),
            'subsection_sort_order' => $this->faker->numberBetween(1, 10),
            'sort_order' => $this->faker->numberBetween(1, 10),
            'minimum' => $minimum,
            'maximum' => $maximum,
            'select_options' => $selectOptions,
            'required_columns' => implode(',', $this->faker->randomElements(['1', '2', '3', '4', '5'])),
        ];
    }
}
