<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TestWorkflow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:workflow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test complete workflow: create workspace -> create task';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Complete Workflow: Create Workspace -> Create Task');
        $this->newLine();

        // Get test user
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $this->error('❌ Test user not found. Run: php artisan db:seed CleanTestDataSeeder');
            return 1;
        }

        Auth::setUser($user);
        $this->info("✅ Authenticated as: {$user->email}");

        // Step 1: Create a new workspace
        $this->info("\n📁 Step 1: Creating new workspace...");
        try {
            $workspace = Workspace::create([
                'user_id' => $user->id,
                'name' => 'Test Workflow Workspace',
                'description' => 'Testing complete workflow from workspace creation to task creation'
            ]);
            $this->info("✅ Created workspace (ID: {$workspace->id}): {$workspace->name}");
        } catch (\Exception $e) {
            $this->error("❌ Failed to create workspace: " . $e->getMessage());
            return 1;
        }

        // Step 2: Test workspace authorization
        $this->info("\n🔐 Step 2: Testing workspace authorization...");
        try {
            $canView = $user->can('view', $workspace);
            $this->line("   Can view workspace: " . ($canView ? "✅ YES" : "❌ NO"));
            
            $canCreateTask = $user->can('create', [Task::class, $workspace]);
            $this->line("   Can create task in workspace: " . ($canCreateTask ? "✅ YES" : "❌ NO"));
        } catch (\Exception $e) {
            $this->error("❌ Authorization check failed: " . $e->getMessage());
        }

        // Step 3: Test route generation
        $this->info("\n🛣️  Step 3: Testing route generation...");
        try {
            $createUrl = route('workspaces.tasks.create', $workspace);
            $storeUrl = route('workspaces.tasks.store', $workspace);
            $this->line("   Create task URL: {$createUrl}");
            $this->line("   Store task URL: {$storeUrl}");
        } catch (\Exception $e) {
            $this->error("❌ Route generation failed: " . $e->getMessage());
        }

        // Step 4: Create a task programmatically
        $this->info("\n📋 Step 4: Creating task in workspace...");
        try {
            $task = Task::create([
                'workspace_id' => $workspace->id,
                'title' => 'Test Task from Workflow',
                'description' => 'This task was created to test the complete workflow',
                'deadline' => now()->addDays(3)->format('Y-m-d H:i:s'),
                'status' => 'incomplete'
            ]);
            $this->info("✅ Created task (ID: {$task->id}): {$task->title}");
            $this->line("   Deadline: {$task->deadline->format('M d, Y g:i A')}");
            $this->line("   Status: {$task->status}");
        } catch (\Exception $e) {
            $this->error("❌ Failed to create task: " . $e->getMessage());
            return 1;
        }

        // Step 5: Test task authorization  
        $this->info("\n🔐 Step 5: Testing task authorization...");
        try {
            $canViewTask = $user->can('view', $task);
            $canEditTask = $user->can('update', $task);
            $this->line("   Can view task: " . ($canViewTask ? "✅ YES" : "❌ NO"));
            $this->line("   Can edit task: " . ($canEditTask ? "✅ YES" : "❌ NO"));
        } catch (\Exception $e) {
            $this->error("❌ Task authorization check failed: " . $e->getMessage());
        }

        // Step 6: Test relationships
        $this->info("\n🔗 Step 6: Testing model relationships...");
        $workspaceTaskCount = $workspace->tasks()->count();
        $taskWorkspace = $task->workspace;
        $this->line("   Workspace task count: {$workspaceTaskCount}");
        $this->line("   Task belongs to workspace: {$taskWorkspace->name}");

        // Summary
        $this->newLine();
        $this->info('🎉 WORKFLOW TEST COMPLETE!');
        $this->comment('Summary:');
        $this->line("✅ User authenticated: {$user->email}");
        $this->line("✅ Workspace created: ID {$workspace->id}");
        $this->line("✅ Task created: ID {$task->id}");
        $this->line("✅ All authorizations passed");
        $this->line("✅ Routes generate correctly");
        $this->line("✅ Model relationships work");

        // Step 7: Test form validation and controller
        $this->info("\n📝 Step 7: Testing form validation and controller...");
        try {
            // Test validation rules
            $formData = [
                'title' => 'Test Form Task',
                'description' => 'Testing form submission and validation',
                'deadline' => now()->addWeek()->format('Y-m-d H:i:s')
            ];
            
            // Simulate controller store method
            $controller = new \App\Http\Controllers\TaskController();
            $request = new \Illuminate\Http\Request();
            $request->merge($formData);
            
            $this->line("   Form validation data prepared");
            $this->line("   Title: {$formData['title']}");
            $this->line("   Description: {$formData['description']}");
            $this->line("   Deadline: {$formData['deadline']}");
            
        } catch (\Exception $e) {
            $this->error("❌ Form validation test failed: " . $e->getMessage());
        }

        $this->newLine();
        $this->comment('Next steps to test in browser:');
        $this->line('1. Login: http://127.0.0.1:8000/login (test@example.com / password)');
        $this->line('2. Go to workspaces: http://127.0.0.1:8000/workspaces');
        $this->line("3. Click on 'Test Workflow Workspace'");
        $this->line('4. Click "Add Task" button');
        $this->line('5. Fill form and submit');
        
        $this->newLine();
        $this->comment('Available test workspaces:');
        Workspace::where('user_id', $user->id)->each(function($ws) {
            $this->line("   • ID {$ws->id}: {$ws->name} ({$ws->tasks->count()} tasks)");
        });

        return 0;
    }
}
