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
                'must_change_password' => true,
            ]
        );

        // regist Anonymous Group
        User::updateOrCreate(
            ['type' => UserType::GROUP_ANONYMOUS],
            [
                'name' => __(UserType::GROUP_ANONYMOUS->string()),
            ]            
        );

        // regist NonMember Group
        User::updateOrCreate(
            ['type' => UserType::GROUP_NON_MEMBER],
            [
                'name' => __(UserType::GROUP_NON_MEMBER->string()),
            ]            
        );

        // regist NonMember Group
        User::updateOrCreate(
            ['type' => UserType::ANONYMOUS_USER],
            [
                'name'   => __(UserType::ANONYMOUS_USER->string()),
                'status' => UserStatus::LOCKED,
            ]            
        );
    }
}
