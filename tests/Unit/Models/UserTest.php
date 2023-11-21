<?php

namespace Tests\Unit\Models;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation()
    {
        $user = User::factory()->create();

        $this->assertModelExists($user);
    }

    public function test_user_has_tasks()
    {
        $user = User::factory()->hasTasks(5)->create();

        $this->assertCount(5, $user->tasks);
    }

}
