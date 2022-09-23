<?php

namespace Tests\Feature;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCheckTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }

    public function testパスワード変更のテスト()
    {
        $user = User::factory()->create(['must_change_password' => true]);

        $this->assertTrue($user->must_change_password);

        // パスワード変更要求があるのでパスワード変更画面に遷移する。
        $response = $this->actingAs($user)->get('/home');
        $response->assertRedirect('my/password');
        $response->assertSessionHas('alert_messages', function($value){
            if(array_key_exists('warning', $value)){
                if(count($value['warning']) > 0){
                    return $value['warning'][0] === 'パスワードを変更して下さい。';
                }
            }
            return false;
        });

        // パスワードを変更したので普通に遷移する。
        $user->refresh();
        $user->password = '';
        $user->save();
        $this->assertFalse($user->must_change_password);

        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);
    }

    public function testStatusがロック()
    {
        $user = User::factory()->create(['status' => UserStatus::LOCKED]);

        $response = $this->actingAs($user)->get('/home');
        $response->assertRedirect('login');
        $response->assertSessionHas('alert_messages', function($value){
            if(array_key_exists('warning', $value)){
                if(count($value['warning']) > 0){
                    return $value['warning'][0] === '管理者の承認待ちです。';
                }
            }
            return false;
        });
    }

    public function testStatusが登録後()
    {
        $user = User::factory()->create(['status' => UserStatus::REGISTERD]);

        $response = $this->actingAs($user)->get('/home');
        $response->assertRedirect('login');
        $response->assertSessionHas('alert_messages', function($value){
            if(array_key_exists('warning', $value)){
                if(count($value['warning']) > 0){
                    return $value['warning'][0] === '管理者の承認待ちです。';
                }
            }
            return false;
        });
    }
}
