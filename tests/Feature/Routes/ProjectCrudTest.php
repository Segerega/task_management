<?php

namespace Tests\Feature\Routes;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;


    public function test_non_admins_unable_to_create_project()
    {
        $projectData = [
            'title' => 'Sample Project',
            'description' => 'Sample project description',
        ];

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->postJson('/api/projects', $projectData);

        $response->assertStatus(403);
    }
    public function test_non_logged_users_unable_to_create_project()
    {
        $projectData = [
            'title' => 'Sample Project',
            'description' => 'Sample project description',
        ];

        $user = User::factory()->create();
        $response = $this->postJson('/api/projects', $projectData);

        $response->assertStatus(401);
    }


    public function test_authenticated_admins_can_create_project()
    {
        $projectData = [
            'title' => 'Sample Project',
            'description' => 'Sample project description',
        ];

        $user = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($user, 'api')->postJson('/api/projects', $projectData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', $projectData);
    }

    public function test_show_project()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($user, 'api')->getJson('/api/projects/' . $project->id);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $project->id,
                'title' => $project->title,
            ]);
    }

    public function test_update_project()
    {
        $project = Project::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ];

        $user = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($user, 'api')->putJson('/api/projects/' . $project->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', $updatedData);
    }

    public function test_delete_project()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($user, 'api')->deleteJson('/api/projects/' . $project->id);

        $response->assertStatus(204);
        $findProject = Project::find($project->id);
        $this->assertNull($findProject);
    }


}
