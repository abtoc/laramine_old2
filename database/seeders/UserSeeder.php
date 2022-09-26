<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // regist Administrator
        User::updateOrCreate(
            ['login' => 'admin'],
            [
                'type'                 => UserType::USER,
                'name'                 => __('Administrator'),
                'login'                => 'admin',
                'email'                => 'admin@example.com',
                'password'             => Hash::make('admin'),
                'status'               => UserStatus::ACTIVE,
                'admin'                => true,
                'must_change_password' => true,
            ]
        );

    }
}
