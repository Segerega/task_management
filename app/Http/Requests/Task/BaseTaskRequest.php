<?php

namespace App\Http\Requests\Task;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class BaseTaskRequest extends FormRequest
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

        // Get the task ID or project ID from the request
        $taskId = $this->route('task');
        $projectId = $this->input('project_id');

        // If we have a task ID, we only need to check the task's ownership
        if ($taskId) {
            return $user->tasks->contains($taskId);
        }

        // If we have a project ID, we only need to check the project's ownership
        if ($projectId) {
            return $user->projects->contains($projectId);
        }

        // If none of the above, the user is not authorized
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
