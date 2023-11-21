<?php

namespace Tests\Feature\Routes;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {

        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create()->assignRole('admin');
        $user_3 = User::factory()->create();

        $project = Project::factory()->create();
        $taskData = [
            'title' => 'Sample Task',
            'description' => 'This is a sample task description',
            'project_id' => $project->id,
        ];

        $response = $this->actingAs($user_2, 'api')->postJson('/api/tasks', $taskData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_user_can_view_task()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $project->users()->attach($user->id);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'project_id' => $project->id, // Set the project_id directly here
        ]);

        $response = $this->actingAs($user, 'api')->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson($task->toArray());
    }

    public function test_user_can_update_task()
    {
        $task = Task::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'description' => 'Updated description',
        ];

        $user = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($user, 'api')->putJson('/api/tasks/' . $task->id, $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $updatedData);
    }


    public function test_user_can_delete_task()
    {
        $user = User::factory()->create()->assignRole('admin');
        $task = Task::factory()->create();

        $response = $this->actingAs($user, 'api')->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $findTask = Task::find($task->id);
        $this->assertNull($findTask);
    }
}
