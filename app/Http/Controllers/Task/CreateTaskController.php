<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\JsonResponse;

class CreateTaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    /**
     * Constructor to inject the task service.
     *
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Handle the creation of a new task.
     *
     * @param CreateTaskRequest $request
     * @return JsonResponse
     */
    public function __invoke(CreateTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated(), auth()->id());
        return response()->json($task, 201);
    }
}
