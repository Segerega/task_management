<?php

namespace App\Http\Requests\Task;

use App\Models\Task;

class TaskUpdateRequest extends BaseTaskRequest
{
    /***
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'sometimes|required|string|max:255',
            'description'       => 'sometimes|nullable|string',
            'status'            => 'sometimes|integer|in:' . implode(',', array_keys(Task::getStatuses())),
            'deadline'          => 'sometimes|nullable|date|after_or_equal:today',
        ];
    }
}
