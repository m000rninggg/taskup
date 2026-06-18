<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_member_can_update_a_task(): void
    {
        [$user, $task] = $this->createTaskForTeamMember();

        $response = $this->actingAs($user)->patch(route('tasks.update', $task), [
            'title' => 'Обновлённая задача',
            'description' => 'Новое описание',
            'deadline' => '2026-07-01',
            'status' => 'done',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Обновлённая задача',
            'description' => 'Новое описание',
            'status' => 'done',
        ]);
    }

    public function test_team_member_can_delete_a_task(): void
    {
        [$user, $task] = $this->createTaskForTeamMember();

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_team_member_can_update_task_status_with_json_response(): void
    {
        [$user, $task] = $this->createTaskForTeamMember();

        $response = $this->actingAs($user)->patchJson(route('tasks.status.update', $task), [
            'status' => 'in_progress',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'status' => 'in_progress',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress',
        ]);
    }

    public function test_user_outside_team_cannot_update_or_delete_a_task(): void
    {
        [, $task] = $this->createTaskForTeamMember();
        $outsider = User::factory()->create();

        $this->actingAs($outsider)->patch(route('tasks.update', $task), [
            'title' => 'Чужое изменение',
            'description' => null,
            'deadline' => null,
            'status' => 'done',
        ])->assertForbidden();

        $this->actingAs($outsider)->delete(route('tasks.destroy', $task))
            ->assertForbidden();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Исходная задача',
        ]);
    }

    private function createTaskForTeamMember(): array
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Команда',
            'owner_id' => $user->id,
        ]);
        $team->users()->attach($user);

        $project = Project::create([
            'team_id' => $team->id,
            'title' => 'Проект',
        ]);

        $task = Task::create([
            'project_id' => $project->id,
            'assigned_user_id' => $user->id,
            'created_by' => $user->id,
            'title' => 'Исходная задача',
            'description' => 'Исходное описание',
            'status' => 'todo',
        ]);

        return [$user, $task];
    }
}
