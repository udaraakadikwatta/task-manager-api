<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;
    protected User $user;

    /**
     * Set up the test environment before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = JWTAuth::fromUser($this->user);
    }

    /**
     * Returns the headers required for authenticated requests.
     *
     * @return array<string, string>
     */
    protected function headers(): array
    {
        return [
            'Authorization' => "Bearer {$this->token}",
            'Accept' => 'application/json',
        ];
    }

    /**
     * Test if an authenticated user can fetch their own tasks.
     */
    public function test_authenticated_user_can_fetch_tasks(): void
    {
        Task::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/tasks', $this->headers());

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * Test if an authenticated user can successfully create a task.
     */
    public function test_authenticated_user_can_create_task(): void
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
        ];

        $response = $this->postJson('/api/tasks', $taskData, $this->headers());

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'New Task']);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    /**
     * Test if an authenticated user can update one of their tasks.
     */
    public function test_authenticated_user_can_update_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $updatedData = ['title' => 'Updated Title'];

        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData, $this->headers());

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Title']);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Title']);
    }

    /**
     * Test if an authenticated user can mark their task as completed.
     */
    public function test_authenticated_user_can_complete_task(): void
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        $response = $this->patchJson("/api/tasks/{$task->id}/complete", [], $this->headers());

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => 'completed']);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    /**
     * Test if an authenticated user can soft delete one of their tasks.
     */
    public function test_authenticated_user_can_delete_task(): void
    {
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/tasks/{$task->id}", [], $this->headers());

        $response->assertStatus(204);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    /**
     * Test that a guest (unauthenticated user) cannot create a task.
     */
    public function test_guest_cannot_create_task(): void
    {
        $taskData = [
            'title' => 'Guest Task Attempt',
            'description' => 'This should not be allowed',
        ];

        $response = $this->postJson('/api/tasks', $taskData, [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }
}
