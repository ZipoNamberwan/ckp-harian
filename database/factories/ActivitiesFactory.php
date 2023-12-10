<?php

namespace Database\Factories;

use App\Models\Activities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activities>
 */
class ActivitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Activities::class;

    public function definition(): array
    {
        return [
            'date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'activity_plan' => fake()->sentence(),
            'activity_name' => fake()->sentence(),
            'achievement' => fake()->sentence(),
            'proggress' => fake()->numberBetween(1, 100),
            'is_skp' => true,
            'user_id' => fake()->numberBetween(2, 28),
            'time_start' => '08:00:00',
            'time_end' => '08:00:00',
        ];
    }
}
