<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_member_can_comment_on_a_task(): void
    {
        [$user, $task] = $this->createTask();

        $this->actingAs($user)
            ->post(route('comments.store', $task), [
                'content' => 'Новый комментарий',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('comments', [
            'task_id' => $task->id,
            'user_id' => $user->id,
            'content' => 'Новый комментарий',
        ]);
    }

    public function test_user_outside_team_cannot_comment_on_a_task(): void
    {
        [, $task] = $this->createTask();
        $outsider = User::factory()->create();

        $this->actingAs($outsider)
            ->post(route('comments.store', $task), [
                'content' => 'Чужой комментарий',
            ])
            ->assertForbidden();

        $this->assertDatabaseCount('comments', 0);
    }

    private function createTask(): array
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Команда',
            'owner_id' => $user->id,
        ]);
        $team->users()->attach($user);

        $project = Project::create([
            'team_id' => $team->id,
            'created_by' => $user->id,
            'title' => 'Проект',
        ]);

        $task = Task::create([
            'project_id' => $project->id,
            'created_by' => $user->id,
            'title' => 'Задача',
            'status' => 'todo',
        ]);

        return [$user, $task];
    }
}
