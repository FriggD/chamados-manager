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
        $status_novo = Status::where('name', 'novo')->first();
        $collections = Category::all();

        return [
            'title' => $this->faker->sentence,
            'due_date' => $this->faker->dateTimeBetween('now', '+15 days')->format('Y-m-d'),
            'solution_date' => null,
            'category_id' => $collections->random()->id,
            'status_id' => $status_novo->id,
        ];
    }
}