<?php

namespace Tests\Feature;

use App\Enums\Permissions;
use App\Models\Group;
use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\UseCases\Role\AttachAction;
use App\UseCases\Role\HasAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleHasActionTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
        $this->seed();
    }

    public function test_ユーザのパーミッション確認()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = Role::factory()->create(['permissions' => [Permissions::EDIT_PROJECT->value]]);
        $attach = new AttachAction();
        $action = new HasAction();

        $attach($project->id, $user->id, $role->id);

        $result = $action($project, $user, Permissions::EDIT_PROJECT);
        $this->assertTrue($result);

        $result = $action($project, $user, Permissions::DELETE_PROJECT);
        $this->assertFalse($result);
    }

    public function test_グループのパーミッション確認()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $group->users()->attach($user->id);
        $role = Role::factory()->create(['permissions' => [Permissions::EDIT_PROJECT->value]]);
        $attach = new AttachAction();
        $action = new HasAction();

        $attach($project->id, $group->id, $role->id);

        $result = $action($project, $user, Permissions::EDIT_PROJECT);
        $this->assertTrue($result);

        $result = $action($project, $user, Permissions::DELETE_PROJECT);
        $this->assertFalse($result);
    }

    public function test_ユーザのパーミッション確認_親プロジェクト()
    {
        $parent  = Project::factory()->create();
        $project = Project::factory()->create(['parent_id' => $parent->id, 'inherit_members' => true]);
        $user = User::factory()->create();
        $role = Role::factory()->create(['permissions' => [Permissions::EDIT_PROJECT->value]]);
        $attach = new AttachAction();
        $action = new HasAction();

        $attach($parent->id, $user->id, $role->id);

        $result = $action($project, $user, Permissions::EDIT_PROJECT);
        $this->assertTrue($result);

        $result = $action($project, $user, Permissions::DELETE_PROJECT);
        $this->assertFalse($result);
    }

    public function test_グループのパーミッション確認_親プロジェクト()
    {
        $parent  = Project::factory()->create();
        $project = Project::factory()->create(['parent_id' => $parent->id, 'inherit_members' => true]);
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $group->users()->attach($user->id);
        $role = Role::factory()->create(['permissions' => [Permissions::EDIT_PROJECT->value]]);
        $attach = new AttachAction();
        $action = new HasAction();

        $attach($project->id, $group->id, $role->id);

        $result = $action($project, $user, Permissions::EDIT_PROJECT);
        $this->assertTrue($result);

        $result = $action($project, $user, Permissions::DELETE_PROJECT);
        $this->assertFalse($result);
    }

}


