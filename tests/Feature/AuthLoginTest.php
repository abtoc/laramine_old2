<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
        $this->seed();
    }
    /**
     * @return void
     */
    public function testAdminでログインを行う()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインを実行
        $response = $this->post('login', [
            'login' => 'admin',
            'password' => 'admin'
        ]);

        // 認証されていることをチェック
        $this->assertTrue(Auth::check());

        // ログイン後にホームにログインサれていることを確認
        $response->assertRedirect('home');

        // ログアウトを行う
        $response = $this->post('logout');

        // 認証サれていないことをチェック
        $this->assertFalse(Auth::check());

        // ログアウト後にホームに返っていることを確認
        $response->assertRedirect('');
    }

    public function testパスワード違い()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインを実行
        $response = $this->post('login', [
            'login' => 'admin',
            'password' => 'xxxx'
        ]);

        // エラーメッセージ確認
        $response->assertSessionHasErrors(['login' => 'ログイン情報が登録されていません。']);

        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインページに遷移することを確認
        $response->assertRedirect('');
    }

    public function testユーザID違い()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインを実行
        $response = $this->post('login', [
            'login' => 'xxxx',
            'password' => 'admin'
        ]);

        // エラーメッセージ確認
        $response->assertSessionHasErrors(['login' => 'ログイン情報が登録されていません。']);

        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインページに遷移することを確認
        $response->assertRedirect('');
    }

    public function testログイン画面require()
    {
        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインを実行
        $response = $this->post('login', [
            'login' => '',
            'password' => ''
        ]);

        // エラーメッセージ確認
        $response->assertSessionHasErrors([
            'login' => 'ログインIDは必ず指定してください。',
            'password' => 'パスワードは必ず指定してください。',
        ]);

        // 認証されていないことを確認する
        $this->assertFalse(Auth::check());

        // ログインページに遷移することを確認
        $response->assertRedirect('');
    }

}
