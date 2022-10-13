<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Member;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\UseCases\Role\AttachAction;
use Tests\TestCase;


class RoleAttachActionTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
        $this->seed();
    }

    public function test_プロジェクトにロールをアタッチする()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $roles = Role::factory()->count(3)->create();
        $action = new AttachAction();

        $action($project->id, $user->id, [$roles[0]->id, $roles[1]->id, $roles[2]->id,]);

        $this->assertDatabaseHas('member', ['project_id' => $project->id, 'user_id' => $user->id]);
        $member = Member::query()
                    ->whereProjectId($project->id)
                    ->whereUserId($user->id)
                    ->first();
        foreach($roles as $role){
            $this->assertDatabaseHas('member_roles', ['member_id' => $member->id, 'role_id' => $role->id]);
        }
    }

    public function test_プロジェクトにロールをアタッチする_Group()
    {
        $project = Project::factory()->create();
        $group = Group::factory()->create();
        $roles = Role::factory()->count(3)->create();
        $action = new AttachAction();

        $action($project->id, $group->id, [$roles[0]->id, $roles[1]->id, $roles[2]->id,]);

        $this->assertDatabaseHas('member', ['project_id' => $project->id, 'user_id' => $group->id]);
        $member = Member::query()
                    ->whereProjectId($project->id)
                    ->whereUserId($group->id)
                    ->first();
        foreach($roles as $role){
            $this->assertDatabaseHas('member_roles', ['member_id' => $member->id, 'role_id' => $role->id]);
        }
    }

    public function test_プロジェクトにロールをアタッチを変更する()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $roles = Role::factory()->count(3)->create();
        $action = new AttachAction();

        $action($project->id, $user->id, [$roles[0]->id, $roles[1]->id, $roles[2]->id,]);

        $this->assertDatabaseHas('member', ['project_id' => $project->id, 'user_id' => $user->id]);
        $member = Member::query()
                    ->whereProjectId($project->id)
                    ->whereUserId($user->id)
                    ->first();
        foreach($roles as $role){
            $this->assertDatabaseHas('member_roles', ['member_id' => $member->id, 'role_id' => $role->id]);
        }

        $action($project->id, $user->id, [$roles[0]->id, $roles[1]->id,]);

        $this->assertDatabaseHas('member', ['project_id' => $project->id, 'user_id' => $user->id]);
        $member = Member::query()
                    ->whereProjectId($project->id)
                    ->whereUserId($user->id)
                    ->first();

        $this->assertDatabaseHas('member_roles', ['member_id' => $member->id, 'role_id' => $roles[0]->id]);
        $this->assertDatabaseHas('member_roles', ['member_id' => $member->id, 'role_id' => $roles[1]->id]);
        $this->assertDatabaseMissing('member_roles', ['member_id' => $member->id, 'role_id' => $roles[2]->id]);
    }
}
