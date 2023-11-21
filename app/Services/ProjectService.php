<?php

namespace App\Services;

use App\Contracts\ProjectServiceInterface;
use App\Models\Project;
use App\Models\Task;
use App\Traits\BaseServiceRestoreTrait;


/**
 * Service class for managing projects.
 */
class ProjectService extends BaseService implements ProjectServiceInterface
{
    use BaseServiceRestoreTrait;

    /**
     * Create a new ProjectService instance.
     *
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function getStatistics($userId = null)
    {
        // Query for total projects
        $totalProjectsQuery = Project::query();
        if ($userId) {
            $totalProjectsQuery->whereHas('users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        $totalProjects = $totalProjectsQuery->count();

        // Query for total tasks
        $totalTasksQuery = Task::query();
        if ($userId) {
            $totalTasksQuery->whereHas('project.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        $totalTasks = $totalTasksQuery->count();

        // Query for completed tasks
        $completedTasksQuery = Task::where('status', Task::STATUS_COMPLETED);
        if ($userId) {
            $completedTasksQuery->whereHas('project.users', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }
        $completedTasks = $completedTasksQuery->count();

        // Return the statistics
        return [
            'total_projects'    => $totalProjects,
            'total_tasks'       => $totalTasks,
            'completed_tasks'   => $completedTasks,
        ];
    }


}
