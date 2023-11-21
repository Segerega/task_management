<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_access_protected_route()
    {
        // Arrange: create a user
        $user = User::factory()->create();

        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->getJson('/api/projects');
        $response->assertStatus(200);
    }


    public function test_unauthenticated_user_cannot_access_protected_route()
    {
        // Act: try to access a protected route without logging in
        $response = $this->get('/api/projects');

        $response->assertStatus(401);
    }
}
