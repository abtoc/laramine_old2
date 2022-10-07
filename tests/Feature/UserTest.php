<?php

namespace Tests\Feature;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }

    public function test_ユーザ一覧()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_users = User::factory()->create(['admin' => false, 'admin_users' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_admin)->get(route('users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_users)->get(route('users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get(route('users.index'));
        $response->assertStatus(404);
    }

    public function test_ユーザー登録()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_users = User::factory()->create(['admin' => false, 'admin_users' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_other)->get(route('users.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_users)->get(route('users.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_admin)->get(route('users.create'));
        $response->assertStatus(200);

        $user_template = [
            'name' => 'テストユーザー',
            'login' => 'test01',
            'email' => 'test01@example.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd',
            'admin' => '1',
            'must_change_password' => '1',
        ];

        $response = $this->actingAs($user_admin)->post(route('users.store'), $user_template);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users',[
            'type' => UserType::USER,
            'name' => $user_template['name'],
            'login' => $user_template['login'],
            'email' => $user_template['email'],
            'admin' => true,
            'must_change_password' => true,
        ]);
        $user = User::whereLogin($user_template['login'])->first();
        $this->assertTrue(Hash::check($user_template['password'], $user->password));

    }

    public function test_ユーザー登録_required()
    {
        $user_admin = User::factory()->create(['admin' => true]);

        $user_template = [
            'name' => '',
            'login' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $response = $this->actingAs($user_admin)->post(route('users.store'), $user_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
            'login' => 'ログインIDは必ず指定してください。',
            'email' => 'メールアドレスは必ず指定してください。',
            'password' => 'パスワードは必ず指定してください。',
        ]);
    }

    public function test_ユーザー登録_unique_confirmed()
    {
        $user_admin = User::factory()->create(['admin' => true]);

        $user_template = [
            'name' => 'テストユーザー',
            'login' => $user_admin->login,
            'email' => $user_admin->email,
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rdx',
        ];

        $response = $this->actingAs($user_admin)->post(route('users.store'), $user_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'login' => 'ログインIDの値は既に存在しています。',
            'email' => 'メールアドレスの値は既に存在しています。',
            'password' => 'パスワードと、確認フィールドとが、一致していません。',
        ]);
    }

    public function test_ユーザー編集()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_users = User::factory()->create(['admin' => false, 'admin_users' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $user       = User::factory()->create();

        $response = $this->actingAs($user_other)->get(route('users.edit', ['user' => $user]));
        $response->assertStatus(404);

        $response = $this->actingAs($user_users)->get(route('users.edit', ['user' => $user]));
        $response->assertStatus(200);

        $response = $this->actingAs($user_admin)->get(route('users.edit', ['user' => $user]));
        $response->assertStatus(200);

        $user_template = [
            '_method' => 'PUT',
            'name' => 'テストユーザー',
            'login' => $user->login,
            'email' => $user->email,
            'admin' => '1',
            'must_change_password' => '1',
        ];

        $response = $this->actingAs($user_admin)->post(route('users.update', ['user' => $user]), $user_template);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users',[
            'type' => UserType::USER,
            'name' => $user_template['name'],
            'login' => $user_template['login'],
            'email' => $user_template['email'],
            'admin' => true,
            'must_change_password' => true,
        ]);
 
    }

    public function test_ユーザー編集_required()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user       = User::factory()->create();

        $user_template = [
            '_method' => 'PUT',
            'name' => '',
            'login' => '',
            'email' => '',
            'admin' => '1',
            'must_change_password' => '1',
        ];

        $response = $this->actingAs($user_admin)->post(route('users.update', ['user' => $user]), $user_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
            'login' => 'ログインIDは必ず指定してください。',
            'email' => 'メールアドレスは必ず指定してください。',
        ]);
    }

    public function test_ユーザー編集_unique()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user       = User::factory()->create();

        $user_template = [
            '_method' => 'PUT',
            'name' => 'テストユーザー',
            'login' => $user_admin->login,
            'email' => $user_admin->email,
            'admin' => '1',
            'must_change_password' => '1',
        ];

        $response = $this->actingAs($user_admin)->post(route('users.update', ['user' => $user]), $user_template);
        $response->assertRedirect('');

        $response->assertSessionHasErrors([
            'login' => 'ログインIDの値は既に存在しています。',
            'email' => 'メールアドレスの値は既に存在しています。',
        ]);
    }

    public function test_ユーザー削除()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_users = User::factory()->create(['admin' => false, 'admin_users' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $user1      = User::factory()->create();
        $user2      = User::factory()->create();

        $response = $this->actingAs($user_other)->post(route('users.destroy', ['user'=>$user1]),[
            '_method' => 'DELETE',
        ]);
        $response->assertStatus(404);

        $response = $this->actingAs($user_users)->post(route('users.destroy', ['user'=>$user1]),[
            '_method' => 'DELETE',
        ]);
        $response->assertRedirect(route('users.index'));
        $this->assertNull(User::find($user1->id));

        $response = $this->actingAs($user_admin)->post(route('users.destroy', ['user'=>$user2]),[
            '_method' => 'DELETE',
        ]);
        $response->assertRedirect(route('users.index'));
        $this->assertNull(User::find($user2->id));

        $response = $this->actingAs($user_admin)->post(route('users.destroy', ['user'=>$user_admin]),[
            '_method' => 'DELETE',
        ]);
        $response->assertStatus(404);
    }

    public function test_ユーザーロック()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_users = User::factory()->create(['admin' => false, 'admin_users' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $user1      = User::factory()->create();
        $user2      = User::factory()->create();

        $response = $this->actingAs($user_other)->post(route('users.lock', ['user'=>$user1]),[
            '_method' => 'PUT',
        ]);
        $response->assertStatus(404);

        $response = $this->actingAs($user_users)->post(route('users.lock', ['user'=>$user1]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('users.index'));
        $user1 = User::find($user1->id);
        $this->assertTrue($user1->status === UserStatus::LOCKED);

        $response = $this->actingAs($user_admin)->post(route('users.lock', ['user'=>$user2]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('users.index'));
        $user2 = User::find($user2->id);
        $this->assertTrue($user2->status === UserStatus::LOCKED);

        $response = $this->actingAs($user_admin)->post(route('users.lock', ['user'=>$user_admin]),[
            '_method' => 'PUT',
        ]);
        $response->assertStatus(404);
    }

    public function test_ユーザーアンロック()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_users = User::factory()->create(['admin' => false, 'admin_users' => true]);
        $user_other = User::factory()->create(['admin' => false]);
        $user1      = User::factory()->create(['status' => UserStatus::LOCKED]);
        $user2      = User::factory()->create(['status' => UserStatus::LOCKED]);

        $response = $this->actingAs($user_other)->post(route('users.unlock', ['user'=>$user1]),[
            '_method' => 'PUT',
        ]);
        $response->assertStatus(404);

        $response = $this->actingAs($user_users)->post(route('users.unlock', ['user'=>$user1]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('users.index'));
        $user1 = User::find($user1->id);
        $this->assertTrue($user1->status === UserStatus::ACTIVE);

        $response = $this->actingAs($user_admin)->post(route('users.unlock', ['user'=>$user2]),[
            '_method' => 'PUT',
        ]);
        $response->assertRedirect(route('users.index'));
        $user2 = User::find($user2->id);
        $this->assertTrue($user2->status === UserStatus::ACTIVE);

        $response = $this->actingAs($user_admin)->post(route('users.unlock', ['user'=>$user_admin]),[
            '_method' => 'PUT',
        ]);
        $response->assertStatus(404);
    }

}
