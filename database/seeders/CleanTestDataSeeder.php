<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;

class CleanTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean slate - remove all data (disable foreign key checks)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Task::truncate();
        Workspace::truncate();
        User::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('🗑️  Cleared all existing data');

        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create multiple test workspaces for the same user
        $workspace1 = Workspace::create([
            'user_id' => $user->id,
            'name' => 'My First Workspace',
            'description' => 'This is my first workspace for testing',
        ]);
        
        $workspace2 = Workspace::create([
            'user_id' => $user->id,
            'name' => 'My Second Workspace', 
            'description' => 'This is my second workspace for testing',
        ]);

        $this->command->info("✅ Created user (ID: {$user->id}): {$user->email}");
        $this->command->info("✅ Created workspace 1 (ID: {$workspace1->id}): {$workspace1->name}");
        $this->command->info("✅ Created workspace 2 (ID: {$workspace2->id}): {$workspace2->name}");
        $this->command->info("🔑 Login credentials: test@example.com / password");
        $this->command->info("🌐 Both workspaces owned by same user - no 404 errors!");
    }
}