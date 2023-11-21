<?php

namespace App\Http\Requests\Project;

use App\Http\Requests\BaseAdminRequest;

class ProjectGetStatisticsRequest extends BaseAdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Check if the requesting user is an admin or the owner
        $targetUserId = $this->route('userId');
        $user = $this->user();

        return $user->hasRole('admin') || $user->id == $targetUserId;
    }
}
