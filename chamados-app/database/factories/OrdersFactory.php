<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Orders;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Orders::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'due_date' => $this->faker->dateTimeBetween('now', '+7 days')->format('Y-m-d'),
            'solution_date' => $this->faker->dateTimeBetween('+8 days', '+14 days')->format('Y-m-d'),
            'category_id' => $this->faker->numberBetween(1, 4),
            'status_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}