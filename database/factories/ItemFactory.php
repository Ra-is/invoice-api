<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'unit_price' => $this->faker->randomFloat(2, 1, 50),
            'quantity' =>   $this->faker->numberBetween(1, 30),
            'amount' => $this->faker->randomFloat(2, 10, 50),
            'description' => $this->faker->text
        ];
    }
}
