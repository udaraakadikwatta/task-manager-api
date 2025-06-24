<?php 

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Http\JsonResponse;

class UpdateTaskController extends Controller
{
    protected TaskServiceInterface $taskService;

    /**
     * Constructor to apply authentication middleware and inject task service.
     *
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        $this->middleware('auth:api');
        $this->taskService = $taskService;
    }

    /**
     * Update the specified task if it belongs to the authenticated user.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function __invoke(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        abort_if($task->user_id !== auth()->id(), 403);

        $task = $this->taskService->updateTask($task, $request->validated());
        return response()->json($task);
    }
}
