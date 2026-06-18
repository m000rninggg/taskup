<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_open_and_update_project_settings(): void
    {
        [$owner, $project] = $this->createOwnedProject();

        $this->actingAs($owner)
            ->get(route('projects.settings', $project))
            ->assertOk()
            ->assertSee('Настройки');

        $this->actingAs($owner)
            ->patch(route('projects.settings.update', $project), [
                'title' => 'Новое название',
                'description' => 'Новое описание',
            ])
            ->assertRedirect(route('projects.settings', $project));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Новое название',
            'description' => 'Новое описание',
        ]);
    }

    public function test_owner_can_add_project_member_by_username(): void
    {
        [$owner, $project] = $this->createOwnedProject();
        $member = User::factory()->create(['username' => 'new_member']);

        $this->actingAs($owner)
            ->post(route('projects.members.store', $project), [
                'username' => 'NEW_MEMBER',
            ])
            ->assertRedirect(route('projects.settings', $project));

        $this->assertDatabaseHas('team_user', [
            'team_id' => $project->team_id,
            'user_id' => $member->id,
        ]);

    }

    public function test_non_owner_cannot_access_project_settings(): void
    {
        [$owner, $project] = $this->createOwnedProject();
        $member = User::factory()->create();
        $project->team->users()->attach($member);

        $this->actingAs($member)
            ->get(route('projects.main', $project))
            ->assertOk()
            ->assertDontSee(route('projects.settings', $project));

        $this->actingAs($member)
            ->get(route('projects.settings', $project))
            ->assertForbidden();

        $this->actingAs($member)
            ->patch(route('projects.settings.update', $project), [
                'title' => 'Чужое название',
                'description' => null,
            ])
            ->assertForbidden();

        $this->actingAs($member)
            ->post(route('projects.members.store', $project), [
                'username' => $owner->username,
            ])
            ->assertForbidden();
    }

    private function createOwnedProject(): array
    {
        $owner = User::factory()->create();
        $team = Team::create([
            'name' => 'Команда',
            'owner_id' => $owner->id,
        ]);
        $team->users()->attach($owner);

        $project = Project::create([
            'team_id' => $team->id,
            'title' => 'Проект',
            'description' => 'Описание',
        ]);

        return [$owner, $project];
    }
}
