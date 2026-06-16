<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCreationModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_be_created_from_projects_modal(): void
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Команда проекта',
            'owner_id' => $user->id,
        ]);
        $team->users()->attach($user);

        $this->actingAs($user)
            ->get(route('projects.index'))
            ->assertOk()
            ->assertSee('id="create-project-modal"', false)
            ->assertSee('Команда проекта');

        $this->actingAs($user)
            ->post(route('projects.store'), [
                'team_id' => $team->id,
                'title' => 'Новый проект',
                'description' => 'Описание проекта',
            ])
            ->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', [
            'team_id' => $team->id,
            'created_by' => $user->id,
            'title' => 'Новый проект',
        ]);
    }

    public function test_project_modal_reopens_after_validation_error(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('projects.index'))
            ->post(route('projects.store'), [])
            ->assertSessionHasErrors(['team_id', 'title'])
            ->assertRedirect(route('projects.index'));

        $this->actingAs($user)
            ->get(route('projects.index'))
            ->assertSee("document.getElementById('create-project-modal')?.showModal()", false);
    }
}
