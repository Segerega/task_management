<?php

namespace Tests\Feature\Middlewares;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckProjectDeadlineTest extends TestCase
{
    use RefreshDatabase;

    private function updateProject($status, $subDays){
        // Create a user
        $project = Project::factory()->create([
            'title' => 'Title',
            'description' => 'Description',
            'status' => $status,
            'deadline' => now()->subDays($subDays)
        ]);

        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ];

        $user = User::factory()->create()->assignRole('admin');

        return $this->actingAs($user, 'api')->putJson('/api/projects/' . $project->id, $updatedData);
    }

    public function test_project_with_future_deadline_in_progress_passes()
    {
        $status = Project::STATUS_IN_PROGRESS;
        $subDays = -10;
        $response = $this->updateProject($status, $subDays);
        $response->assertStatus(200);
    }

    public function test_project_with_past_deadline_in_progress_passes()
    {
        $status = Project::STATUS_IN_PROGRESS;
        $subDays = 10;
        $response = $this->updateProject($status, $subDays);
        $response->assertStatus(200);
    }

    public function test_project_with_past_deadline_completed_fails()
    {
        $status = Project::STATUS_COMPLETED;
        $subDays = 10;
        $response = $this->updateProject($status, $subDays);
        $response->assertStatus(403);
    }
}
