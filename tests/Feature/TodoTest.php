<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase; // Resets database between tests

    /** @test */
    public function a_user_can_create_a_todo()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // ✅ Authenticate the test user

        $todoData = [
            'title' => 'Buy groceries',
            'completed' => false,
        ];

        $response = $this->post('/todos', $todoData);

        $this->assertDatabaseHas('todos', $todoData); // Ensure data exists
    }

    /** @test */
    public function a_user_can_mark_a_todo_as_completed()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // ✅ Authenticate the test user

        $todo = Todo::factory()->create([ 'user_id' => $user->id]);

        $this->put("/todos/{$todo->id}", ['completed' => true]);

        $this->assertDatabaseHas('todos', ['id' => $todo->id, 'completed' => true]);
    }

    /** @test */
    public function a_user_can_delete_a_todo()
    {
        $user = User::factory()->create();
        $this->actingAs($user); // ✅ Authenticate the test user

        $todo = Todo::factory()->create([ 'user_id' => $user->id]);

        $response = $this->delete("/todos/{$todo->id}");

        $this->assertDatabaseMissing('todos', ['id' => $todo->id]); // ✅ Confirm it's deleted
    }

}
