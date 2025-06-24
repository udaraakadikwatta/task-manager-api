<?php

namespace App\Services\Interfaces;

use App\Models\Task;
use Illuminate\Support\Collection;

interface TaskServiceInterface
{
    /**
     * Retrieve tasks for a given user, optionally filtered by status.
     *
     * @param int $userId
     * @param string|null $status
     * @return Collection<int, Task>
     */
    public function getUserTasks(int $userId, ?string $status = null): Collection;

    /**
     * Create a new task for the specified user.
     *
     * @param array<string, mixed> $data
     * @param int $userId
     * @return Task
     */
    public function createTask(array $data, int $userId): Task;

    /**
     * Update the specified task with the provided data.
     *
     * @param Task $task
     * @param array<string, mixed> $data
     * @return Task
     */
    public function updateTask(Task $task, array $data): Task;

    /**
     * Delete the specified task.
     *
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task): void;

    /**
     * Mark the specified task as completed.
     *
     * @param Task $task
     * @return Task
     */
    public function markCompleted(Task $task): Task;
}
