<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BasecTransitionTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
        $this->seed();
    }

    public function test画面遷移テスト()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get(route('login'));
        $response->assertStatus(200);

        $response = $this->get(route('home'));
        $response->assertRedirect('login'); // ログインしていないため200で返らない

        $resposne = $this->get(route('my.password.edit'));
        $response->assertRedirect('login');
    }

    public function test認証画面遷移テスト()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);

        $response = $this->get(route('register'));
        $response->assertStatus(200);
        
        $response = $this->get(route('password.request'));
        $response->assertStatus(200);

        $response = $this->get(route('password.confirm'));
        $response->assertRedirect(route('login')); // ログインしていないため200で返らない

        $response = $this->get(route('my.password.edit'));
        $response->assertRedirect(route('login')); // ログインしていないため200で返らない

    }

    public function test認証画面遷移ログインテスト()
    {
        // ログインしていないことを確認
        $this->assertFalse(Auth::check());

        // Adminユーザ取得
        $user = User::find(1);
        $user->must_change_password = false;
        $user->save();
        
        $response = $this->actingAs($user)->get(route('home'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('password.request'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('my.password.edit'));
        $response->assertStatus(200);
    }
}