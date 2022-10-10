<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
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

    public function test_ロール一覧()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_admin)->get(route('roles.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get(route('roles.index'));
        $response->assertStatus(404);
    }

    public function test_ロール登録()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_other)->get(route('roles.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('roles.create'));
        $response->assertStatus(200);

        $role_template = [
            'name' => 'テストロール',
            'permissions[]' => 'edit_project',
            'permissions[]' => 'close_project',
            'permissions[]' => 'delete_project',
            'permissions[]' => 'manage_members',
        ];

        $response = $this->actingAs($user_admin)->post(route('roles.store'), $role_template);
        $response->assertRedirect(route('roles.index'));
 
        $this->assertDatabaseHas('roles',[
            'name' => $role_template['name'],
            'position' => 1,
            'builtin' => 0,
        ]);

    }

    public function test_ロール登録_require()
    {
        $user_admin = User::factory()->create(['admin' => true]);

        $role_template = [
            'name' => '',
        ];

        $response = $this->actingAs($user_admin)->post(route('roles.store'), $role_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
        ]);
    }

    public function test_ロール編集()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $role       = Role::factory()->create();

        $response = $this->actingAs($user_other)->get(route('roles.edit', ['role' => $role]));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('roles.edit', ['role' => $role]));
        $response->assertStatus(200);

        $role_template = [
            '_method' => 'PUT',
            'name' => 'テストロール',
            'permissions[]' => 'edit_project',
            'permissions[]' => 'close_project',
            'permissions[]' => 'delete_project',
            'permissions[]' => 'manage_members',
        ];

        $response = $this->actingAs($user_admin)->post(route('roles.update', ['role'=>$role]), $role_template);
        $response->assertRedirect(route('roles.index'));
 
        $this->assertDatabaseHas('roles',[
            'name' => $role_template['name'],
            'position' => 1,
            'builtin' => 0,
        ]);
    }

    public function test_ロール編集_require()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $role       = Role::factory()->create();

        $role_template = [
            '_method' => 'PUT',
            'name' => '',
        ];

        $response = $this->actingAs($user_admin)->post(route('roles.update', ['role'=>$role]), $role_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
        ]);
    }

    public function test_ロール削除()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $role       = Role::factory()->create();

        $response = $this->actingAs($user_other)->post(route('roles.destroy', ['role'=>$role]),[
            '_method' => 'DELETE',
        ]);
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->post(route('roles.destroy', ['role'=>$role]),[
            '_method' => 'DELETE',
        ]);
        $response->assertRedirect(route('roles.index'));
        $this->assertNull(Role::find($role->id));
    }

    public function test_ロール移動_上から下へ()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $roles      = Role::factory()->count(5)->create();

        foreach($roles as $key => $role){
            $role->position = $key + 1;
            $role->save();
        }

        $response =  $this->actingAs($user_admin)->post(route('roles.move'), [
            '_method' => 'PUT',
            'from' => $roles[4]->id,
            'to'   => $roles[0]->id,
        ]);
        $response->assertRedirect(route('roles.index'));

        foreach($roles as $role){
            $role->refresh();
        }

        $this->assertEquals($roles[0]->position, 2);
        $this->assertEquals($roles[1]->position, 3);
        $this->assertEquals($roles[2]->position, 4);
        $this->assertEquals($roles[3]->position, 5);
        $this->assertEquals($roles[4]->position, 1);
    }

    public function test_ロール移動_下から上へ()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $roles      = Role::factory()->count(5)->create();

        foreach($roles as $key => $role){
            $role->position = $key + 1;
            $role->save();
        }

        $response =  $this->actingAs($user_admin)->post(route('roles.move'), [
            '_method' => 'PUT',
            'from' => $roles[0]->id,
            'to'   => $roles[4]->id,
        ]);
        $response->assertRedirect(route('roles.index'));

        foreach($roles as $role){
            $role->refresh();
        }

        $this->assertEquals($roles[0]->position, 5);
        $this->assertEquals($roles[1]->position, 1);
        $this->assertEquals($roles[2]->position, 2);
        $this->assertEquals($roles[3]->position, 3);
        $this->assertEquals($roles[4]->position, 4);
    }
}
