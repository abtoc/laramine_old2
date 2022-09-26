<?php

namespace Tests\Feature;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }


    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_グループ一覧()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_admin)->get(route('groups.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get(route('groups.index'));
        $response->assertStatus(404);
    }

    public function test_グループ登録()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_other)->get(route('groups.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('groups.create'));
        $response->assertStatus(200);

        $group_template = [
            'name' => 'テストグループ',
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.store'), $group_template);
        $response->assertRedirect(route('groups.index'));
 
        $this->assertDatabaseHas('users',[
            'type' => UserType::GROUP,
            'name' => $group_template['name'],
            'login' => '',
            'email' => '',
            'password' => '',
            'status' => UserStatus::ACTIVE,
        ]);
    }

    public function test_グループ登録_ユーザ名ならOK()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_other)->get(route('groups.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('groups.create'));
        $response->assertStatus(200);

        $group_template = [
            'name' => $user_other->name,
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.store'), $group_template);
        $response->assertRedirect(route('groups.index'));
 
        $this->assertDatabaseHas('users',[
            'type' => UserType::GROUP,
            'name' => $group_template['name'],
            'login' => '',
            'email' => '',
            'password' => '',
            'status' => UserStatus::ACTIVE,
        ]);
    }

    public function test_グループ登録_require()
    {
        $user_admin = User::factory()->create(['admin' => true]);

        $group_template = [
            'name' => '',
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.store'), $group_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
        ]);
    }

    public function test_グループ登録_unique()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $group      = Group::factory()->create();

        $group_template = [
            'name' => $group->name,
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.store'), $group_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前の値は既に存在しています。',
        ]);
    }

    public function test_グループ編集()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $group      = Group::factory()->create();

        $response = $this->actingAs($user_other)->get(route('groups.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('groups.create'));
        $response->assertStatus(200);

        $group_template = [
            '_method' => 'PUT',
            'name' => 'テストグループ',
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.update', ['group'=>$group]), $group_template);
        $response->assertRedirect(route('groups.index'));
 
        $this->assertDatabaseHas('users',[
            'type' => UserType::GROUP,
            'name' => $group_template['name'],
            'login' => '',
            'email' => '',
            'password' => '',
            'status' => UserStatus::ACTIVE,
        ]);
    }

    public function test_グループ編集_ユーザ名ならOK()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $group      = Group::factory()->create();

        $response = $this->actingAs($user_other)->get(route('groups.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('groups.create'));
        $response->assertStatus(200);

        $group_template = [
            '_method' => 'PUT',
            'name' => $user_other->name,
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.update', ['group'=>$group]), $group_template);
        $response->assertRedirect(route('groups.index'));
 
        $this->assertDatabaseHas('users',[
            'type' => UserType::GROUP,
            'name' => $group_template['name'],
            'login' => '',
            'email' => '',
            'password' => '',
            'status' => UserStatus::ACTIVE,
        ]);
    }

    public function test_グループ編集_require()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $group      = Group::factory()->create();

        $group_template = [
            '_method' => 'PUT',
            'name' => '',
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.update', ['group'=>$group]), $group_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
        ]);
    }

    public function test_グループ編集_unique()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $group      = Group::factory()->create();
        $group_other = Group::factory()->create();

        $group_template = [
            '_method' => 'PUT',
            'name' => $group_other->name,
        ];

        $response = $this->actingAs($user_admin)->post(route('groups.update',['group'=>$group]), $group_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前の値は既に存在しています。',
        ]);
    }

    public function test_group削除()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $group      = Group::factory()->create();

        $response = $this->actingAs($user_other)->post(route('groups.destroy', ['group'=>$group]),[
            '_method' => 'DELETE',
        ]);
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->post(route('groups.destroy', ['group'=>$group]),[
            '_method' => 'DELETE',
        ]);
        $response->assertRedirect(route('groups.index'));
        $this->assertNull(Group::find($group->id));
    }
}
