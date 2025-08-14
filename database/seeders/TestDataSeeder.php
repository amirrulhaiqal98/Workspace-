<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Workspace;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create test user
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Get or create test workspace
        $workspace = Workspace::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'Test Workspace'],
            [
                'description' => 'A test workspace for debugging',
            ]
        );

        $this->command->info("User (ID: {$user->id}) and workspace (ID: {$workspace->id}) ready");
        $this->command->info("Login credentials: test@example.com / password");
        
        // Show current data
        $this->command->info("Users in database: " . User::count());
        $this->command->info("Workspaces in database: " . Workspace::count());
        $this->command->info("Workspace owner ID: " . $workspace->user_id);
    }
}