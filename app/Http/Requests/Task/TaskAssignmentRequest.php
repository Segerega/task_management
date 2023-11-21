<?php

namespace App\Http\Requests\Task;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskAssignmentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        // Admins are always authorized
        if ($user->hasRole('admin')) {
            return true;
        }

        // Get the task ID from the route, if available
        $taskId = $this->route('task');
        // If we have a task ID, we check the task's project ownership
        if ($taskId) {
            $task = Task::with('project.users')->find($taskId);

            // Check if the task exists and if the user is part of the project
            if ($task && $task->project && $task->project->users->contains($user->id)) {
                return true;
            }
        }

        // If none, the user is not authorized
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

}
