<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GateAdminTest extends TestCase
{
    protected function setup(): void
    {
        parent::setup();

        $this->artisan('migrate');
    }

    public function test管理者権限のテスト()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->get('/admin');
        $response->assertRedirect('login');

        $response = $this->actingAs($user_admin)->get('/admin');
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get('/admin');
        $response->assertStatus(404);
    }
}
