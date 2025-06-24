<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\JsonResponse;

class CompleteTaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    /**
     * Constructor to set middleware and inject task service.
     *
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->middleware('auth:api');
        $this->taskService = $taskService;
    }

    /**
     * Mark the given task as completed if owned by authenticated user.
     *
     * @param Task $task
     * @return JsonResponse
     */
    public function __invoke(Task $task): JsonResponse
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $task = $this->taskService->markCompleted($task);
        return response()->json($task);
    }
}
