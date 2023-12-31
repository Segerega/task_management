<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectDeadline
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $projectId = $request->route('projectId');

        if ($projectId) {
            $project = Project::find($projectId);

            if ($project && $project->deadline && now()->greaterThan($project->deadline)) {
                if ($project->status == Project::STATUS_COMPLETED) {
                    return response()->json(['message' => 'Project deadline has passed. Modifications are not allowed.'], 403);
                } else {
                    $project->status = Project::STATUS_COMPLETED;
                    $project->save();
                }
            }
        }

        return $next($request);
    }
}
