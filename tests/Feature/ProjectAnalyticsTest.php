<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_analytics_url_redirects_to_correct_url(): void
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Analytics team',
            'owner_id' => $user->id,
        ]);
        $team->users()->attach($user);
        $project = Project::create([
            'team_id' => $team->id,
            'title' => 'Analytics project',
        ]);

        $this->actingAs($user)
            ->get("/projects/{$project->id}/analitics")
            ->assertRedirect(route('projects.analytics', $project));

        $this->actingAs($user)
            ->get(route('projects.analytics', $project))
            ->assertOk();
    }
}
