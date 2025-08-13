<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'deadline' => fake()->dateTimeBetween('+1 day', '+1 month'),
            'status' => fake()->randomElement(['incomplete', 'completed']),
            'completed_at' => function (array $attributes) {
                return $attributes['status'] === 'completed' ? fake()->dateTimeBetween('-1 week', 'now') : null;
            },
            'workspace_id' => \App\Models\Workspace::factory(),
        ];
    }
}
