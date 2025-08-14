<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DebugTaskRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:task-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug task route access issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== DEBUG: Task Route Access ===');
        $this->newLine();

        // Check database
        $this->info('1. Checking database:');
        $users = User::count();
        $workspaces = Workspace::count();
        $tasks = Task::count();
        
        $this->line("   Users: $users");
        $this->line("   Workspaces: $workspaces");
        $this->line("   Tasks: $tasks");
        
        $this->line("\n   All workspaces:");
        Workspace::all(['id', 'name', 'user_id'])->each(function($workspace) {
            $this->line("     ID: {$workspace->id}, Name: '{$workspace->name}', Owner: {$workspace->user_id}");
        });
        
        $this->line("\n   All users:");
        User::all(['id', 'email', 'name'])->each(function($user) {
            $this->line("     ID: {$user->id}, Email: '{$user->email}', Name: '{$user->name}'");
        });
        $this->newLine();

        // Get test data
        $user = User::first();
        $workspace = Workspace::first();

        if (!$user || !$workspace) {
            $this->error('❌ ERROR: No test user or workspace found!');
            $this->line('   Run: php artisan db:seed TestDataSeeder');
            return 1;
        }

        $this->info('2. Test data found:');
        $this->line("   User ID: {$user->id} ({$user->email})");
        $this->line("   Workspace ID: {$workspace->id} ({$workspace->name})");
        $this->line("   Workspace Owner ID: {$workspace->user_id}");
        $match = $workspace->user_id == $user->id ? "✓ YES" : "❌ NO";
        $this->line("   Ownership match: $match");
        $this->newLine();

        // Test route generation
        $this->info('3. Testing route generation:');
        try {
            $createUrl = route('workspaces.tasks.create', $workspace);
            $this->line("   Create URL: $createUrl");
            
            $storeUrl = route('workspaces.tasks.store', $workspace);
            $this->line("   Store URL: $storeUrl");
        } catch (\Exception $e) {
            $this->error("❌ Route generation failed: " . $e->getMessage());
        }
        $this->newLine();

        // Test policies
        $this->info('4. Testing policies:');
        Auth::setUser($user);
        
        try {
            $canView = $user->can('view', $workspace);
            $viewResult = $canView ? "✓ YES" : "❌ NO";
            $this->line("   Can view workspace: $viewResult");
            
            $canCreate = $user->can('create', [Task::class, $workspace]);
            $createResult = $canCreate ? "✓ YES" : "❌ NO";
            $this->line("   Can create task: $createResult");
        } catch (\Exception $e) {
            $this->error("   Policy check failed: " . $e->getMessage());
        }
        $this->newLine();

        $this->info('=== DEBUGGING COMPLETE ===');
        $this->newLine();
        
        $this->comment('RECOMMENDED STEPS:');
        $this->line('1. Make sure you\'re logged in with: test@example.com / password');
        $this->line('2. Access workspace list first: http://127.0.0.1:8000/workspaces');
        $this->line('3. Click on "Test Workspace" to go to workspace details');
        $this->line('4. From there, use the "Create Task" button instead of direct URL');
        
        return 0;
    }
}
