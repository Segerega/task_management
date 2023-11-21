<?php

namespace App\Http\Requests\Task;

class TaskCreateRequest extends BaseTaskRequest
{
    /***
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'project_id'    => 'required|exists:projects,id',
            'status'        => 'nullable|integer',
            'deadline'      => 'nullable|date|after_or_equal:today',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'A project title is required.',
            'project_id.required' => 'A project_id is required.',
        ];
    }
}
