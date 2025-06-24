<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListTasksController extends Controller
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
     * Retrieve the list of tasks for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $tasks = $this->taskService->getUserTasks(auth()->id(), $request->query('status'));
        return response()->json($tasks);
    }
}
