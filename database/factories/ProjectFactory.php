<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rand_user_id    = rand(1, User::count());

        return [
            'name' => fake()->word(),
            'description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
            'user_id' => $rand_user_id,
        ];
    }
}
