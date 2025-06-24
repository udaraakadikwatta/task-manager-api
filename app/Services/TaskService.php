<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Support\Collection;

class TaskService implements TaskServiceInterface
{
    /**
     * Retrieve tasks for a given user, optionally filtered by status.
     *
     * @param int $userId
     * @param string|null $status
     * @return Collection<int, Task>
     */
    public function getUserTasks(int $userId, ?string $status = null): Collection
    {
        return Task::where('user_id', $userId)
            ->when($status === TaskStatus::Completed->value, fn($query) => $query->where('status', TaskStatus::Completed->value))
            ->when($status === TaskStatus::Pending->value, fn($query) => $query->where('status', TaskStatus::Pending->value))
            ->latest()
            ->get();
    }

    /**
     * Create a new task for the specified user.
     *
     * @param array<string, mixed> $data
     * @param int $userId
     * @return Task
     */
    public function createTask(array $data, int $userId): Task
    {
        return Task::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);
    }

    /**
     * Update the specified task with provided data.
     *
     * @param Task $task
     * @param array<string, mixed> $data
     * @return Task
     */
    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    /**
     * Delete the specified task.
     *
     * @param Task $task
     * @return void
     */
    public function deleteTask(Task $task): void
    {
        $task->delete();
    }

    /**
     * Mark the specified task as completed.
     *
     * @param Task $task
     * @return Task
     */
    public function markCompleted(Task $task): Task
    {
        $task->update(['status' => TaskStatus::Completed->value]);
        return $task;
    }
}
