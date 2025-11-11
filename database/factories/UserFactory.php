<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone_number' => '5192681650', //$this->faker->phoneNumber(),
            'password' => 'jXab23stm', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @param Carbon|null $date
     * @return UserFactory
     */
    public function unverified(Carbon $date = null): self
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => $date ?? Carbon::now(),
        ]);
    }
}
