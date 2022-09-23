<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    public function createUsers()
    {
        $user_template = ['type' => UserType::USER, 'password' => Hash::make('P@ssw0rd'),];
        $users = [
            ['name' => 'テストユーザ01', 'login' => 'test01', 'email' => 'test01@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ02', 'login' => 'test02', 'email' => 'test02@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ03', 'login' => 'test03', 'email' => 'test03@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ04', 'login' => 'test04', 'email' => 'test04@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ05', 'login' => 'test05', 'email' => 'test05@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ06', 'login' => 'test06', 'email' => 'test06@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ07', 'login' => 'test07', 'email' => 'test07@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ08', 'login' => 'test08', 'email' => 'test08@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ09', 'login' => 'test09', 'email' => 'test09@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ10', 'login' => 'test10', 'email' => 'test10@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ11', 'login' => 'test11', 'email' => 'test11@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ12', 'login' => 'test12', 'email' => 'test12@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ13', 'login' => 'test13', 'email' => 'test13@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ14', 'login' => 'test14', 'email' => 'test14@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ15', 'login' => 'test15', 'email' => 'test15@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ16', 'login' => 'test16', 'email' => 'test16@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ17', 'login' => 'test17', 'email' => 'test17@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ18', 'login' => 'test18', 'email' => 'test18@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ19', 'login' => 'test19', 'email' => 'test19@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ20', 'login' => 'test20', 'email' => 'test20@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ21', 'login' => 'test21', 'email' => 'test21@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ22', 'login' => 'test22', 'email' => 'test22@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ23', 'login' => 'test23', 'email' => 'test23@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ24', 'login' => 'test24', 'email' => 'test24@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ25', 'login' => 'test25', 'email' => 'test25@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ26', 'login' => 'test26', 'email' => 'test26@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ27', 'login' => 'test27', 'email' => 'test27@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ28', 'login' => 'test28', 'email' => 'test28@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ29', 'login' => 'test29', 'email' => 'test29@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
            ['name' => 'テストユーザ30', 'login' => 'test30', 'email' => 'test30@example.com', 'status' => UserStatus::ACTIVE, 'must_change_password' => true, ],
        ];

        foreach($users as $user){
            $user = array_merge($user_template, $user);
            User::updateOrCreate(
                ['login' => $user['login']],
                $user
            );
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers();
    }
}
