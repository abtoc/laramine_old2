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

        $response = $this->actingAs($user_admin)->get(route('users.index'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->get(route('users.index'));
        $response->assertStatus(404);
    }

    public function test_ユーザー登録()
    {
        $user_admin = User::factory()->create(['admin' => true]);
        $user_other = User::factory()->create(['admin' => false]);

        $response = $this->actingAs($user_other)->get(route('users.create'));
        $response->assertStatus(404);

        $response = $this->actingAs($user_admin)->get(route('users.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user_other)->post(route('users.create'), [

        ]);
    }

}
