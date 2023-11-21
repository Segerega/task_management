<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseAdminRequest;

class ProjectCreateRequest extends BaseAdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string', //Description is optional as well,
            'status'        => 'nullable|integer', // Status is optional, default is 0 which is CREATED
            'deadline'      => 'nullable|date|after_or_equal:today', // Deadline is optional
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

        ];
    }
}
