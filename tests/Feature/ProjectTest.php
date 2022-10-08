<?php

namespace Tests\Feature;

use App\Enums\ProjectStatus;
use App\Enums\UserType;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }

    public function test_プロジェクト一覧()
    {
        $user_admin    = User::factory()->create(['admin' => true]);
        $user_projects = User::factory()->create(['admin' => false, 'admin_projects' => true]);
        $user_other    = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_admin)->get(route('projects.admin'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_projects)->get(route('projects.admin'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get(route('projects.admin'));
        $response->assertStatus(404);
    }

    public function test_プロジェクト登録()
    {
        $user_admin    = User::factory()->create(['admin' => true]);
        $user_projects = User::factory()->create(['admin' => false, 'admin_projects' => true]);
        $user_other    = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_other)->get(route('projects.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_projects)->get(route('projects.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_admin)->get(route('projects.create'));
        $response->assertStatus(200);

        $project_template = [
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.store'), $project_template);
        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects',[
            'name' => $project_template['name'],
            'description' => $project_template['description'],
            'status' => ProjectStatus::ACTIVE,
            'inherit_members' => false,
            'is_public' => true,
            'parent_id' => null,
        ]);
    }

    public function test_プロジェクト登録_子プロジェクト作成()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create();

        $project_template = [
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'parent_id' => $project_parent->id,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.store'), $project_template);
        $response->assertRedirect(route('projects.index'));
        $this->assertDatabaseHas('projects',[
            'name' => $project_template['name'],
            'description' => $project_template['description'],
            'status' => ProjectStatus::ACTIVE,
            'inherit_members' => false,
            'is_public' => false,
            'parent_id' => $project_parent->id,
        ]);
        $project_childen = $project_parent->children()->get();
        $this->assertEquals($project_childen->count(), 1);
    }

    public function test_プロジェクト登録_required()
    {
        $user_admin    = User::factory()->create(['admin' => true]);
        $project_template = [
            'name' => '',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.store'), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
        ]);
    }

    public function test_プロジェクト登録_parent_id()
    {
        $user_admin    = User::factory()->create(['admin' => true]);
        $project_template = [
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => 1,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.store'), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'parent_id' => '選択された親プロジェクトIDは正しくありません。',
        ]);
    }

    public function test_プロジェクト登録_inherit_members()
    {
        $user_admin    = User::factory()->create(['admin' => true]);
        $project_template = [
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'inherit_members' => '1',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.store'), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'inherit_members' => '親プロジェクトIDがemptyの場合、メンバーを継承は有効にできません。',
        ]);
    }

    public function test_プロジェクト登録_is_public()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create();

        $project_template = [
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => $project_parent->id,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.store'), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'is_public' => '親プロジェクトが公開になっていません。',
        ]);
    }

    public function test_プロジェクト編集()
    {
        $user_admin    = User::factory()->create(['admin' => true]);
        $user_projects = User::factory()->create(['admin' => false, 'admin_projects' => true]);
        $user_other    = User::factory()->create(['admin' => false]);
        $project       = Project::factory()->create();

        $response = $this->actingAs($user_other)->get(route('projects.edit.setting',['project'=>$project]));
        $response->assertStatus(404);

        $response = $this->actingAs($user_projects)->get(route('projects.edit.setting',['project'=>$project]));
        $response->assertStatus(200);

        $response = $this->actingAs($user_admin)->get(route('projects.edit.setting',['project'=>$project]));
        $response->assertStatus(200);

        $project_template = [
            '_method' => 'PUT',
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.update.setting', ['project'=>$project]), $project_template);
        $response->assertRedirect(route('projects.show', ['project'=>$project]));
        $this->assertDatabaseHas('projects',[
            'name' => $project_template['name'],
            'description' => $project_template['description'],
            'status' => ProjectStatus::ACTIVE,
            'inherit_members' => false,
            'is_public' => true,
            'parent_id' => null,
        ]);
    }

    public function test_プロジェクト編集_子プロジェクト移動()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create();
        $project        = Project::factory()->create(['parent_id' => $project_parent->id]);

        $project_template = [
            '_method' => 'PUT',
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.update.setting', ['project'=>$project]), $project_template);
        $response->assertRedirect(route('projects.show', ['project' => $project]));
        $this->assertDatabaseHas('projects',[
            'name' => $project_template['name'],
            'description' => $project_template['description'],
            'status' => ProjectStatus::ACTIVE,
            'inherit_members' => false,
            'is_public' => false,
            'parent_id' => null,
        ]);
        $project_childen = $project_parent->children()->get();
        $this->assertEquals($project_childen->count(), 0);
    }

    public function test_プロジェクト編集_required()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $project    = Project::factory()->create();

        $project_template = [
            '_method' => 'PUT',
            'name' => '',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.update.setting', ['project'=>$project]), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
        ]);
    }

    public function test_プロジェクト編集_parent_id()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $project    = Project::factory()->create();

        $project_template = [
            '_method' => 'PUT',
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => 100,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.update.setting', ['project'=>$project]), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'parent_id' => '選択された親プロジェクトIDは正しくありません。',
        ]);
    }

    public function test_プロジェクト編集_inherit_members()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $project    = Project::factory()->create();

        $project_template = [
            '_method' => 'PUT',
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'inherit_members' => '1',
            'parent_id' => null,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.update.setting', ['project'=>$project]), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'inherit_members' => '親プロジェクトIDがemptyの場合、メンバーを継承は有効にできません。',
        ]);
    }

    public function test_プロジェクト編集_is_public()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create();
        $project        = Project::factory()->create();

        $project_template = [
            '_method' => 'PUT',
            'name' => 'テストプロジェクト',
            'description' => 'テストプロジェクトの内容',
            'is_public' =>  '1',
            'parent_id' => $project_parent->id,
        ];
        $response = $this->actingAs($user_admin)->post(route('projects.update.setting', ['project'=>$project]), $project_template);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors([
            'is_public' => '親プロジェクトが公開になっていません。',
        ]);
    }

    public function test_プロジェクト_open()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $project    = Project::factory()->create(['status' => ProjectStatus::CLOSED]);

        $response = $this->actingAs($user_admin)->post(route('projects.open', ['project' => $project]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('projects.show', ['project'=>$project]));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => ProjectStatus::ACTIVE,
        ]);
    }

    public function test_プロジェクト_open_ng()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create(['status' => ProjectStatus::CLOSED]);
        $project        = Project::factory()->create(['status' => ProjectStatus::CLOSED, 'parent_id' => $project_parent->id]);

        $response = $this->actingAs($user_admin)->post(route('projects.open', ['project' => $project]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('projects.show', ['project'=>$project]));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => ProjectStatus::CLOSED,
        ]);
    }

    public function test_プロジェクト_close()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $project    = Project::factory()->create(['status' => ProjectStatus::ACTIVE]);

        $response = $this->actingAs($user_admin)->post(route('projects.close', ['project' => $project]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('projects.show', ['project'=>$project]));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => ProjectStatus::CLOSED,
        ]);
    }

    public function test_プロジェクト_close_ng()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create(['status' => ProjectStatus::ACTIVE]);
        $project        = Project::factory()->create(['status' => ProjectStatus::ACTIVE, 'parent_id' => $project_parent->id]);

        $response = $this->actingAs($user_admin)->post(route('projects.close', ['project' => $project_parent]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('projects', [
            'id' => $project_parent->id,
            'status' => ProjectStatus::ACTIVE,
        ]);
    }

    public function test_プロジェクト_archive()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $project    = Project::factory()->create(['status' => ProjectStatus::ACTIVE]);

        $response = $this->actingAs($user_admin)->post(route('projects.archive', ['project' => $project]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('projects.admin'));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'status' => ProjectStatus::ARCHIVE,
        ]);
    }

    public function test_プロジェクト_archive_ng()
    {
        $user_admin     = User::factory()->create(['admin' => true]);
        $project_parent = Project::factory()->create(['status' => ProjectStatus::ACTIVE]);
        $project        = Project::factory()->create(['status' => ProjectStatus::ACTIVE, 'parent_id' => $project_parent->id]);

        $response = $this->actingAs($user_admin)->post(route('projects.archive', ['project' => $project_parent]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect('/');
        $this->assertDatabaseHas('projects', [
            'id' => $project_parent->id,
            'status' => ProjectStatus::ACTIVE,
        ]);
    }
}
