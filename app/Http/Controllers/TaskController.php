<?php

namespace App\Http\Controllers;

use App\Contracts\TaskServiceInterface;
use App\Http\Requests\Task\BaseTaskRequest;
use App\Http\Requests\Task\TaskAssignmentRequest;
use App\Http\Requests\Task\TaskCreateRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class TaskController
 * Controller for handling task-related operations.
 */
class TaskController extends BaseController
{
    /**
     * Create a new TaskController instance.
     *
     * @param TaskServiceInterface $taskService
     */
    public function __construct(TaskServiceInterface $taskService)
    {
        parent::__construct($taskService);
    }


    /**
     * Store a newly created Task in storage.
     *
     * @param TaskCreateRequest $request
     * @return JsonResponse
     */
    public function store(TaskCreateRequest $request):JsonResponse
    {
        $project = $this->service->create($request->validated());
        return response()->json($project, Response::HTTP_CREATED);
    }


    /**
     * Update the specified project in storage.
     *
     * @param TaskUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskUpdateRequest $request, $id)
    {
        $project = $this->service->update($id, $request->validated());
        return response()->json($project);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(BaseTaskRequest $request, $id)
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Restore the specified soft-deleted project.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore(BaseTaskRequest $request, $id)
    {
        $this->service->restore($id);
        return response()->json(['message' => 'Project restored successfully.']);
    }

    /**
     * Assign or reassign a task to a user.
     *
     * @param TaskAssignmentRequest $request
     * @param int $taskId
     * @param null $userId Optional user ID for task assignment. If not provided, assigns to the current user.
     * @return JsonResponse
     */
    public function assign(TaskAssignmentRequest $request, $taskId, $userId = null)
    {
        // Default to the current user if $userId is not provided
        $userId = $userId ?? $request->user()->id;

        // Attempt to assign the task using the service
        $task = $this->service->assignTask($taskId, $userId);

        // If the service returns a task model, the assignment was successful
        if ($task) {
            return response()->json(['message' => 'Task assigned successfully'], 200);
        }

        return response()->json(['message' => 'Failed to assign task'], 422);
    }

}
