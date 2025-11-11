<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $field = Field::factory()->create();

        return [
            'field_id' => $field->id,
            'value' => $field->type === Field::TYPE_NUMBER
                ? (string)$this->faker->randomFloat(2, $field->minimum ?? 0, $field->maximum ?? 100)
                : $this->faker->word(),
            'column' => $this->faker->numberBetween(1, 5),
            'page_date' => $this->faker->date(),
        ];
    }

    /***
     * Set the field for the FieldData.
     *
     * @param Field $field
     * @return self
     */
    public function withField(Field $field): self
    {
        return $this->state(function () use ($field) {
            return [
                'field_id' => $field->id,
            ];
        });
    }
}
