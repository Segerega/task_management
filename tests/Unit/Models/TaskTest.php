<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_belongs_to_project()
    {
        $project = Project::factory()->create();
        $task = Task::factory()->for($project)->create();

        $this->assertTrue($project->is($task->project));
    }

    public function test_task_assignment_to_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        $task->user_id = $user->id;
        $task->save();
        $this->assertTrue($user->is($task->user));
    }

}
