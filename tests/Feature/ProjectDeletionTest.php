<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_owner_can_see_delete_button_and_delete_project(): void
    {
        [$owner, $project] = $this->createProject();

        $this->actingAs($owner)
            ->get(route('projects.index'))
            ->assertOk()
            ->assertSee('delete-project-'.$project->id);

        $this->actingAs($owner)
            ->delete(route('projects.destroy', $project))
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_project_creator_who_is_not_team_owner_cannot_delete_project_or_see_delete_button(): void
    {
        [$owner, $project] = $this->createProject();
        $creator = User::factory()->create();
        $project->team->users()->attach($creator);
        $project->update(['created_by' => $creator->id]);

        $this->actingAs($creator)
            ->get(route('projects.index'))
            ->assertOk()
            ->assertDontSee('delete-project-'.$project->id);

        $this->actingAs($creator)
            ->delete(route('projects.destroy', $project))
            ->assertForbidden();

        $this->assertDatabaseHas('projects', ['id' => $project->id]);

        $this->actingAs($owner)
            ->get(route('projects.index'))
            ->assertOk()
            ->assertSee('delete-project-'.$project->id);
    }

    private function createProject(): array
    {
        $creator = User::factory()->create();
        $team = Team::create([
            'name' => 'Команда',
            'owner_id' => $creator->id,
        ]);
        $team->users()->attach($creator);

        $project = Project::create([
            'team_id' => $team->id,
            'created_by' => $creator->id,
            'title' => 'Проект',
        ]);

        return [$creator, $project];
    }
}
