<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\Traits\HasStatuses;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{

    protected $model = Project::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence, // Generate a random sentence for the project title
            'description' => $this->faker->paragraph, // Generate a random paragraph for the project description
            'status' => $this->faker->randomElement(array_keys(Project::getStatuses())), // Random status
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+1 month'), // Random deadline within the next month
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            // Attach users to the project
            $user = User::factory()->create();
            $project->users()->attach($user);
        });
    }
}
