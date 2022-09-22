<?php

namespace Tests\Feature;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }

    public function testユーザの登録テスト()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ユーザ登録を実行
        $response = $this->post('register', [
            'name' => 'テストユーザー',
            'login' => 'test01',
            'email' => 'test01@test.com',
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd',
        ]);

        // 認証されていることをチェック
        $this->assertTrue(Auth::check());

        // データベースの確認
        $this->assertDatabaseHas(User::class,[
            'type' => UserType::USER,
            'name' => 'テストユーザー',
            'login' => 'test01',
            'email' => 'test01@test.com',
            'status' => UserStatus::REGISTERD,
            'must_change_password' => false,
        ]);
        $user = User::whereLogin('test01')->first();
        $this->assertTrue(Hash::check('P@ssw0rd', $user->password));

        // ログイン後にホームにログインサれていることを確認
        $response->assertRedirect('home');
    }

    public function testユーザの登録テストrequire()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ユーザ登録を実行
        $response = $this->post('register', [
            'name' => '',
            'login' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // 認証されていない事をチェック
        $this->assertFalse(Auth::check());

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'name' => '名前は必ず指定してください。',
            'login' => 'ログインIDは必ず指定してください。',
            'email' => 'メールアドレスは必ず指定してください。',
            'password' => 'パスワードは必ず指定してください。',
        ]);

        // ログイン後にホームにログインサれていることを確認
        $response->assertRedirect('');
    }

    public function testユーザの登録テストident_email_min()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ユーザ登録を実行
        $response = $this->post('register', [
            'name' => 'admin',
            'login' => 'admin admin',
            'email' => 'admin',
            'password' => 'P@ssw0r',
            'password_confirmation' => 'P@ssw0r',
        ]);

        // 認証されていない事をチェック
        $this->assertFalse(Auth::check());

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'login' => '半角英数字と一部の記号( _ - @ . )が使用可能です。',
            'email' => 'メールアドレスには、有効なメールアドレスを指定してください。',
            'password' => 'パスワードは、8文字以上で指定してください。',
        ]);

        // ログイン後にホームにログインサれていることを確認
        $response->assertRedirect('');
    }

    public function testユーザの登録テストunique_confirmed()
    {
        // ユーザ作成
        $user = User::factory()->create();

        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ユーザ登録を実行
        $response = $this->post('register', [
            'name' => $user->name,
            'login' => $user->login,
            'email' => $user->email,
            'password' => 'P@ssw0rd',
            'password_confirmation' => 'P@ssw0rd0',
        ]);

        // 認証されていない事をチェック
        $this->assertFalse(Auth::check());

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'login' => 'ログインIDの値は既に存在しています。',
            'email' => 'メールアドレスの値は既に存在しています。',
            'password' => 'パスワードと、確認フィールドとが、一致していません。',
        ]);

        // ログイン後にホームにログインサれていることを確認
        $response->assertRedirect('');
    }

}
