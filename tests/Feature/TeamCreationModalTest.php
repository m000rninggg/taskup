<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamCreationModalTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_can_be_created_with_comma_separated_usernames(): void
    {
        $owner = User::factory()->create(['username' => 'team_owner']);
        $firstMember = User::factory()->create(['username' => 'first_member']);
        $secondMember = User::factory()->create(['username' => 'second_member']);

        $this->actingAs($owner)
            ->get(route('teams.index'))
            ->assertOk()
            ->assertSee('id="create-team-modal"', false)
            ->assertSee('Имена пользователей');

        $this->actingAs($owner)
            ->post(route('teams.store'), [
                'name' => 'Новая команда',
                'member_usernames' => '@FIRST_MEMBER, second_member',
            ])
            ->assertRedirect(route('teams.index'));

        $team = Team::where('name', 'Новая команда')->firstOrFail();

        $this->assertEqualsCanonicalizing(
            [$owner->id, $firstMember->id, $secondMember->id],
            $team->users()->pluck('users.id')->all()
        );
    }

    public function test_team_is_not_created_when_a_username_does_not_exist(): void
    {
        $owner = User::factory()->create();

        $this->actingAs($owner)
            ->from(route('teams.index'))
            ->post(route('teams.store'), [
                'name' => 'Не должна создаться',
                'member_usernames' => 'missing_user',
            ])
            ->assertSessionHasErrors('member_usernames')
            ->assertRedirect(route('teams.index'));

        $this->assertDatabaseMissing('teams', [
            'name' => 'Не должна создаться',
        ]);

        $this->actingAs($owner)
            ->get(route('teams.index'))
            ->assertSee("document.getElementById('create-team-modal')?.showModal()", false);
    }

    public function test_owner_can_update_team_and_add_member_from_edit_modal(): void
    {
        $owner = User::factory()->create(['username' => 'owner']);
        $member = User::factory()->create(['username' => 'new_member']);
        $team = Team::create([
            'name' => 'Старая команда',
            'owner_id' => $owner->id,
        ]);
        $team->users()->attach($owner);

        $this->actingAs($owner)
            ->get(route('teams.index'))
            ->assertOk()
            ->assertSee('id="edit-team-'.$team->id.'"', false)
            ->assertSee('Редактировать');

        $this->actingAs($owner)
            ->patch(route('teams.update', $team), [
                'name' => 'Обновленная команда',
                'username' => 'new_member',
            ])
            ->assertRedirect(route('teams.index'));

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'name' => 'Обновленная команда',
        ]);

        $this->assertDatabaseHas('team_user', [
            'team_id' => $team->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_owner_can_delete_team(): void
    {
        $owner = User::factory()->create();
        $team = Team::create([
            'name' => 'Удаляемая команда',
            'owner_id' => $owner->id,
        ]);
        $team->users()->attach($owner);

        $this->actingAs($owner)
            ->delete(route('teams.destroy', $team))
            ->assertRedirect(route('teams.index'));

        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
        ]);
    }

    public function test_owner_can_remove_member_from_team(): void
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();
        $team = Team::create([
            'name' => 'Team',
            'owner_id' => $owner->id,
        ]);
        $team->users()->attach([$owner->id, $member->id]);

        $this->actingAs($owner)
            ->delete(route('teams.members.destroy', [$team, $member]))
            ->assertRedirect(route('teams.index'));

        $this->assertDatabaseMissing('team_user', [
            'team_id' => $team->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_member_can_leave_team(): void
    {
        $owner = User::factory()->create();
        $member = User::factory()->create();
        $team = Team::create([
            'name' => 'Team',
            'owner_id' => $owner->id,
        ]);
        $team->users()->attach([$owner->id, $member->id]);

        $this->actingAs($member)
            ->get(route('teams.index'))
            ->assertOk()
            ->assertSee('Выйти из команды');

        $this->actingAs($member)
            ->delete(route('teams.leave', $team))
            ->assertRedirect(route('teams.index'));

        $this->assertDatabaseMissing('team_user', [
            'team_id' => $team->id,
            'user_id' => $member->id,
        ]);
    }

    public function test_separate_team_creation_route_does_not_exist(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/teams/create')
            ->assertNotFound();
    }
}
