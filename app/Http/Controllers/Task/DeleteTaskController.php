<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\JsonResponse;

class DeleteTaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    /**
     * Constructor to apply middleware and inject the task service.
     *
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->middleware('auth:api');
        $this->taskService = $taskService;
    }

    /**
     * Delete the specified task if it belongs to the authenticated user.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function __invoke(Task $task): JsonResponse
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $this->taskService->deleteTask($task);
        return response()->json(null, 204);
    }
}
