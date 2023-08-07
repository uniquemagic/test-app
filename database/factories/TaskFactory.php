<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

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
        $rand_user_id    = rand(1, User::count());
        $rand_project_id = rand(1, Project::count());

        $task_statuses             = Task::STATUSES;
        $rand_task_status_position = rand(0, count($task_statuses));

        return [
            'name'        => fake()->word(),
            'description' => fake()->sentence($nbWords = 6, $variableNbWords = true),
            'user_id'     => $rand_user_id,
            'project_id'  => $rand_project_id,
            'status'      => $task_statuses[$rand_task_status_position] ?? Task::STATUS_BACKLOG,
        ];
    }
}
