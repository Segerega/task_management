<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence, // Random title
            'description' => $this->faker->paragraph, // Random description
            'status' => $this->faker->randomElement(array_keys(Task::getStatuses())), // Random status
            'project_id' => Project::factory(), // Assuming each task belongs to a project
        ];
    }
}
