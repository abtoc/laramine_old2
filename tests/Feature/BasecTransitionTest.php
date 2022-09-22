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

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/home');
        $response->assertRedirect('login'); // ログインしていないため200で返らない

        $resposne = $this->get('/my/reset');
        $response->assertRedirect('login');
    }

    public function test認証画面遷移テスト()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);
        
        $response = $this->get('/password/reset');
        $response->assertStatus(200);

        $response = $this->get('/password/confirm');
        $response->assertRedirect('login'); // ログインしていないため200で返らない
    }

    public function test認証画面遷移ログインテスト()
    {
        // ログインしていないことを確認
        $this->assertFalse(Auth::check());

        // Adminユーザ取得
        $user = User::find(1);
        
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/password/reset');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get('/my/reset');
        $response->assertStatus(200);
    }
}