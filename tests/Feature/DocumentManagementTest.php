<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DocumentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_member_can_create_a_document_topic(): void
    {
        [$user, $project] = $this->createProjectForTeamMember();
        $requestToken = (string) Str::uuid();

        $response = $this->actingAs($user)->post(route('documents.store', $project), [
            'request_token' => $requestToken,
            'title' => 'Техническое описание',
            'category' => 'additional',
            'content' => 'Описание новой темы',
        ]);

        $response->assertRedirect(route('projects.doc', $project));
        $this->assertDatabaseHas('documentation', [
            'project_id' => $project->id,
            'request_token' => $requestToken,
            'updated_by' => $user->id,
            'title' => 'Техническое описание',
            'category' => 'additional',
            'content' => 'Описание новой темы',
        ]);
    }

    public function test_user_outside_team_cannot_create_a_document_topic(): void
    {
        [, $project] = $this->createProjectForTeamMember();
        $outsider = User::factory()->create();

        $this->actingAs($outsider)->post(route('documents.store', $project), [
            'request_token' => (string) Str::uuid(),
            'title' => 'Чужая тема',
            'category' => 'main',
            'content' => null,
        ])->assertForbidden();

        $this->assertDatabaseMissing('documentation', [
            'project_id' => $project->id,
            'title' => 'Чужая тема',
        ]);
    }

    public function test_repeated_document_request_creates_only_one_topic(): void
    {
        [$user, $project] = $this->createProjectForTeamMember();
        $payload = [
            'request_token' => (string) Str::uuid(),
            'title' => 'Единственная тема',
            'category' => 'main',
            'content' => 'Описание',
        ];

        $this->actingAs($user)->post(route('documents.store', $project), $payload);
        $this->actingAs($user)->post(route('documents.store', $project), $payload);

        $this->assertDatabaseCount('documentation', 1);
    }

    public function test_same_request_token_can_be_used_in_different_projects(): void
    {
        [$user, $firstProject] = $this->createProjectForTeamMember();
        $secondProject = Project::create([
            'team_id' => $firstProject->team_id,
            'title' => 'Second project',
        ]);
        $requestToken = (string) Str::uuid();

        $this->actingAs($user)->post(route('documents.store', $firstProject), [
            'request_token' => $requestToken,
            'title' => 'First topic',
            'category' => 'main',
            'content' => null,
        ]);

        $this->actingAs($user)->post(route('documents.store', $secondProject), [
            'request_token' => $requestToken,
            'title' => 'Second topic',
            'category' => 'main',
            'content' => null,
        ]);

        $this->assertDatabaseHas('documentation', [
            'project_id' => $firstProject->id,
            'request_token' => $requestToken,
            'title' => 'First topic',
        ]);
        $this->assertDatabaseHas('documentation', [
            'project_id' => $secondProject->id,
            'request_token' => $requestToken,
            'title' => 'Second topic',
        ]);
        $this->assertDatabaseCount('documentation', 2);
    }

    public function test_team_member_can_update_and_delete_a_document_topic(): void
    {
        [$user, $project] = $this->createProjectForTeamMember();
        $document = Document::create([
            'project_id' => $project->id,
            'updated_by' => $user->id,
            'title' => 'Исходная тема',
            'category' => 'main',
            'content' => 'Исходное описание',
        ]);

        $this->actingAs($user)->patch(route('documents.update', $document), [
            'title' => 'Обновлённая тема',
            'category' => 'additional',
            'content' => 'Новое описание',
        ])->assertRedirect(route('projects.doc', $project));

        $this->assertDatabaseHas('documentation', [
            'id' => $document->id,
            'title' => 'Обновлённая тема',
            'category' => 'additional',
            'content' => 'Новое описание',
        ]);

        $this->actingAs($user)
            ->delete(route('documents.destroy', $document))
            ->assertRedirect(route('projects.doc', $project));

        $this->assertDatabaseMissing('documentation', ['id' => $document->id]);
    }

    private function createProjectForTeamMember(): array
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

        return [$user, $project];
    }
}
