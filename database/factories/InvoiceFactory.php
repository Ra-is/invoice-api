<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'customer_id' => Customer::factory(),
        ];
    }
}
