<?php

namespace Tests\Unit\Models;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_has_owner()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();

        // Attach the user to the project
        $project->users()->attach($user->id);

        // Reload the project to fetch related users
        $project->load('users');

        // Check if the project's users collection contains the user
        $this->assertTrue($project->users->contains($user->id));
    }



}
