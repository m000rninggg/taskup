<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_members_are_visible_to_every_team_member(): void
    {
        $owner = User::factory()->create([
            'name' => 'Владелец команды',
            'username' => 'team_owner',
        ]);
        $member = User::factory()->create([
            'name' => 'Участник команды',
            'username' => 'team_member',
        ]);

        $team = Team::create([
            'name' => 'Команда разработки',
            'owner_id' => $owner->id,
        ]);

        $team->users()->attach([$owner->id, $member->id]);

        $this->actingAs($member)
            ->get(route('teams.index'))
            ->assertOk()
            ->assertSee('Команда разработки')
            ->assertSee('Владелец команды (@team_owner)')
            ->assertSee('Участник команды (@team_member)');
    }
}
