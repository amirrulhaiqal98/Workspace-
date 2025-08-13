<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workspace;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkspaceAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_only_see_own_workspaces(): void
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create workspaces for each user
        $workspace1 = Workspace::factory()->create(['user_id' => $user1->id]);
        $workspace2 = Workspace::factory()->create(['user_id' => $user2->id]);

        // User 1 should only see their workspace
        $this->actingAs($user1)
            ->get(route('workspaces.index'))
            ->assertSee($workspace1->name)
            ->assertDontSee($workspace2->name);

        // User 2 should only see their workspace
        $this->actingAs($user2)
            ->get(route('workspaces.index'))
            ->assertSee($workspace2->name)
            ->assertDontSee($workspace1->name);
    }

    public function test_user_cannot_access_other_users_workspace(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $workspace = Workspace::factory()->create(['user_id' => $user1->id]);

        // User 2 should not be able to access User 1's workspace
        $this->actingAs($user2)
            ->get(route('workspaces.show', $workspace))
            ->assertStatus(403);
    }

    public function test_user_cannot_access_other_users_tasks(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $workspace = Workspace::factory()->create(['user_id' => $user1->id]);
        $task = Task::factory()->create(['workspace_id' => $workspace->id]);

        // User 2 should not be able to access User 1's tasks
        $this->actingAs($user2)
            ->get(route('workspaces.tasks.index', $workspace))
            ->assertStatus(403);

        $this->actingAs($user2)
            ->get(route('workspaces.tasks.show', [$workspace, $task]))
            ->assertStatus(403);
    }

    public function test_guest_cannot_access_workspaces(): void
    {
        $user = User::factory()->create();
        $workspace = Workspace::factory()->create(['user_id' => $user->id]);

        // Guest should be redirected to login
        $this->get(route('workspaces.index'))
            ->assertRedirect(route('login'));

        $this->get(route('workspaces.show', $workspace))
            ->assertRedirect(route('login'));
    }
}
