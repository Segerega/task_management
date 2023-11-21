<?php

namespace Tests\Feature\Routes;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_assigned_to_user()
    {
        // Create a user and a task
        $user = User::factory()->create();
        $assignee = User::factory()->create(); // User to assign the task to
        $project = Project::factory()->create();
        $project->users()->attach($user->id);
        $task = Task::factory()->create(['project_id' => $project->id]);

        // Act as the first user and attempt to assign the task to the second user
        $response = $this->actingAs($user, 'api')->postJson("/api/tasks/{$task->id}/assign/{$assignee->id}");

        // Assertions to ensure the response is correct
        $response->assertStatus(200); // or the status code you expect on success
        $response->assertJson(['message' => 'Task assigned successfully']); // assuming you return a message like this

        // Ensure the task is now assigned to the second user
        $task = $task->fresh(); // Reload the task from the database
        $this->assertEquals($assignee->id, $task->user_id);
    }

    public function test_task_can_be_assigned_to_current_user_if_no_id_provided()
    {
        // Create a user and a task
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $project = Project::factory()->create();
        $project->users()->attach($user2->id);
        $task = Task::factory()->create(['project_id' => $project->id]);

        // Act as the first user and attempt to assign the task to the second user
        $response = $this->actingAs($user2, 'api')->postJson("/api/tasks/{$task->id}/assign");

        // Assertions to ensure the response is correct
        $response->assertStatus(200); // or the status code you expect on success
        $response->assertJson(['message' => 'Task assigned successfully']); // assuming you return a message like this

        // Ensure the task is now assigned to the second user
        $task = $task->fresh(); // Reload the task from the database
        $this->assertEquals($user2->id, $task->user_id);
    }
}
