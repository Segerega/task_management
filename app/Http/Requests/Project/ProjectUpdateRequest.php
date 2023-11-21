<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseAdminRequest;

class ProjectUpdateRequest extends BaseAdminRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'             => 'sometimes|required|string|max:255',
            'description'       => 'nullable|string',
            'status'            => 'sometimes|integer',
            'deadline'          => 'sometimes|date|after_or_equal:today',
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
