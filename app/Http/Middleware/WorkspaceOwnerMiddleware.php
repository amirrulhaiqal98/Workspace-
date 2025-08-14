<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Workspace;

class WorkspaceOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $workspaceId = $request->route('workspace');
        
        if ($workspaceId) {
            $workspace = $workspaceId instanceof Workspace ? $workspaceId : Workspace::findOrFail($workspaceId);
            
            if ($workspace->user_id !== auth()->id()) {
                abort(403, 'You do not have permission to access this workspace.');
            }
        }
        
        return $next($request);
    }
}
