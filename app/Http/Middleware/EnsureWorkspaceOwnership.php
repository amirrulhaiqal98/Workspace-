<?php

namespace App\Http\Middleware;

use App\Models\Workspace;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureWorkspaceOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the workspace from the route
        $workspace = $request->route('workspace');
        
        // If workspace exists and user is not the owner, return 403
        if ($workspace && $workspace instanceof Workspace) {
            if (!Auth::check() || Auth::id() !== $workspace->user_id) {
                abort(403, 'You do not have permission to access this workspace.');
            }
        }
        
        return $next($request);
    }
}
