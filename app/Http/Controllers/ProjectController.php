<?php

// app/Http/Controllers/ProjectController.php

namespace App\Http\Controllers;

use App\Contracts\ProjectServiceInterface;
use App\Http\Requests\BaseAdminRequest;
use App\Http\Requests\Project\ProjectCreateRequest;
use App\Http\Requests\Project\ProjectGetStatisticsRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ProjectController
 * Controller for handling project-related requests.
 */
class ProjectController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @param ProjectServiceInterface $projectService
     */
    public function __construct(ProjectServiceInterface $projectService)
    {
        parent::__construct($projectService);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param ProjectCreateRequest $request
     * @return JsonResponse
     */
    public function store(ProjectCreateRequest $request):JsonResponse
    {
        $project = $this->service->create($request->validated());
        return response()->json($project, Response::HTTP_CREATED);
    }


    /**
     * Update the specified project in storage.
     *
     * @param ProjectUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ProjectUpdateRequest $request, $id)
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
    public function destroy(BaseAdminRequest $request, $id)
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
    public function restore(BaseAdminRequest $request, $id)
    {
        $this->service->restore($id);
        return response()->json(['message' => 'Project restored successfully.']);
    }

    /**
     * Get statistics for projects.
     *
     * @return JsonResponse
     */
    public function statistics(ProjectGetStatisticsRequest $request, $userId = null)
    {
        $stats = $this->service->getStatistics($userId);
        return response()->json($stats);
    }
}
