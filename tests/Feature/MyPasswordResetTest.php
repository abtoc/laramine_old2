<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyPasswordResetTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }

    public function testパスワード変更テスト()
    {
        $password = 'password';
        $new_password = 'password01';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'must_change_password' => true,
        ]);

        $now = Carbon::now();

        $response = $this->actingAs($user)->post('/my/password', [
            'password' => $password,
            'new_password' => $new_password,
            'new_password_confirmation' => $new_password,
        ]);

        $user = User::find($user->id);
        $this->assertTrue(Hash::check($new_password, $user->password));
        $this->assertEquals($user->must_change_password, 0);
        $this->assertTrue($now->gte($user->password_change_at));

        // ログイン後にホームにログインサれていることを確認
        $response->assertRedirect('home');
    }

    public function testパスワード変更テストrequired()
    {
        $password = 'password';
        $new_password = 'password';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->actingAs($user)->post('/my/password', [
            'password' => '',
            'new_password' => '',
            'new_password_confirmation' => '',
        ]);

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'password' => 'パスワードは必ず指定してください。',
            'new_password' => '新パスワードは必ず指定してください。',
        ]);
    }

    public function testパスワード変更テストconfirmed()
    {
        $password = 'password';
        $new_password = 'password01';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->actingAs($user)->post('/my/password', [
            'password' => $password,
            'new_password' => $new_password,
            'new_password_confirmation' => '',
        ]);

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'new_password' => '新パスワードと、確認フィールドとが、一致していません。',
        ]);
    }

    public function testパスワード変更テストdifferent()
    {
        $password = 'password';
        $new_password = 'password01';
        $user = User::factory()->create([
            'password' => Hash::make($password),
        ]);

        $response = $this->actingAs($user)->post('/my/password', [
            'password' => $password,
            'new_password' => $password,
            'new_password_confirmation' => $password,
        ]);

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'new_password' => '新パスワードとパスワードには、異なった内容を指定してください。',
        ]);
    }

}
