<?php

namespace Tests\Feature\Routes;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectRoutesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_project_index_route_for_authenticated_user()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->getJson('/api/projects');
        $response->assertOk();
    }

    public function test_project_index_route_for_unauthenticated_user()
    {
        $response = $this->getJson('/api/projects');
        $response->assertUnauthorized();
    }

    private function generateProjectsAndTasksOfUser($user, $projectNumber = 5, $taskNumber = 3)
    {
        // Create some projects and tasks
        $projects = Project::factory()->count($projectNumber)->create();

        foreach ($projects as $project) {
            // Attach the user to the project
            $project->users()->attach($user->id);

            // Create tasks for the project
            Task::factory()->count($taskNumber)->create([
                'project_id' => $project->id,
                'status' => Task::STATUS_COMPLETED
            ]);
            Task::factory()->count($taskNumber)->create([
                'project_id' => $project->id,
                'status' => Task::STATUS_PENDING
            ]);
        }

    }

    public function test_project_statistics_route()
    {
        // Create a user
        $user = User::factory()->create()->assignRole('admin');
        $this->generateProjectsAndTasksOfUser($user);

        // Make the API call as the authenticated user
        $response = $this->actingAs($user, 'api')->getJson("/api/projects/statistics");

        // Assertions
        $response->assertOk();
        $result = $response->json();

        $this->assertArrayHasKey('total_projects', $result);
        $this->assertArrayHasKey('total_tasks', $result);
        $this->assertArrayHasKey('completed_tasks', $result);

        // Adjusted assertions based on the number of tasks created
        $this->assertEquals(5, $result['total_projects']); // 5 projects created
        $this->assertEquals(30, $result['total_tasks']); // 6 tasks per project * 5 projects
        $this->assertEquals(15, $result['completed_tasks']); // 3 completed tasks per project * 5 projects
    }

    public function test_project_user_statistics_route()
    {
        // Create a user
        $user = User::factory()->create()->assignRole('admin');
        $user2 = User::factory()->create()->assignRole('admin');
        $this->generateProjectsAndTasksOfUser($user);
        $this->generateProjectsAndTasksOfUser($user2, 6, 4);

        // Make the API call as the authenticated user
        $response = $this->actingAs($user, 'api')->getJson("/api/projects/statistics/{$user->id}");

        // Assertions
        $response->assertOk();
        $result = $response->json();

        $this->assertArrayHasKey('total_projects', $result);
        $this->assertArrayHasKey('total_tasks', $result);
        $this->assertArrayHasKey('completed_tasks', $result);

        // Adjusted assertions based on the number of tasks created
        $this->assertEquals(5, $result['total_projects']); // 5 projects created
        $this->assertEquals(30, $result['total_tasks']); // 6 tasks per project * 5 projects
        $this->assertEquals(15, $result['completed_tasks']); // 3 completed tasks per project * 5 projects
    }


}
