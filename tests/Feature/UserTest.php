<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_admin)->get('/users');
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get('/users');
        $response->assertStatus(404);
    }
}
