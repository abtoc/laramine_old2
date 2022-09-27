<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    private function createUsers()
    {
        $user_template = ['type' => UserType::USER, 'password' => Hash::make('P@ssw0rd'),];
        $users = [
            ['name' => 'テストユーザー01', 'login' => 'test01', 'email' => 'test01@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー02', 'login' => 'test02', 'email' => 'test02@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー03', 'login' => 'test03', 'email' => 'test03@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー04', 'login' => 'test04', 'email' => 'test04@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー05', 'login' => 'test05', 'email' => 'test05@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー06', 'login' => 'test06', 'email' => 'test06@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー07', 'login' => 'test07', 'email' => 'test07@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー08', 'login' => 'test08', 'email' => 'test08@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー09', 'login' => 'test09', 'email' => 'test09@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー10', 'login' => 'test10', 'email' => 'test10@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー11', 'login' => 'test11', 'email' => 'test11@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー12', 'login' => 'test12', 'email' => 'test12@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー13', 'login' => 'test13', 'email' => 'test13@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー14', 'login' => 'test14', 'email' => 'test14@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー15', 'login' => 'test15', 'email' => 'test15@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー16', 'login' => 'test16', 'email' => 'test16@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー17', 'login' => 'test17', 'email' => 'test17@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー18', 'login' => 'test18', 'email' => 'test18@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー19', 'login' => 'test19', 'email' => 'test19@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー20', 'login' => 'test20', 'email' => 'test20@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー21', 'login' => 'test21', 'email' => 'test21@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー22', 'login' => 'test22', 'email' => 'test22@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー23', 'login' => 'test23', 'email' => 'test23@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー24', 'login' => 'test24', 'email' => 'test24@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー25', 'login' => 'test25', 'email' => 'test25@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー26', 'login' => 'test26', 'email' => 'test26@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー27', 'login' => 'test27', 'email' => 'test27@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー28', 'login' => 'test28', 'email' => 'test28@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー29', 'login' => 'test29', 'email' => 'test29@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー30', 'login' => 'test30', 'email' => 'test30@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
        ];

        foreach($users as $user){
            $user = array_merge($user_template, $user);
            User::updateOrCreate(
                ['login' => $user['login']],
                $user
            );
        }
    }

    private function createGroups()
    {
        $groups = [
            ['name' => 'テストグループ01'],
            ['name' => 'テストグループ02'],
            ['name' => 'テストグループ03'],
            ['name' => 'テストグループ04'],
            ['name' => 'テストグループ05'],
            ['name' => 'テストグループ06'],
            ['name' => 'テストグループ07'],
            ['name' => 'テストグループ08'],
            ['name' => 'テストグループ09'],
            ['name' => 'テストグループ10'],
            ['name' => 'テストグループ11'],
            ['name' => 'テストグループ12'],
            ['name' => 'テストグループ13'],
            ['name' => 'テストグループ14'],
            ['name' => 'テストグループ15'],
            ['name' => 'テストグループ16'],
            ['name' => 'テストグループ17'],
            ['name' => 'テストグループ18'],
            ['name' => 'テストグループ19'],
            ['name' => 'テストグループ10'],
        ];

        foreach($groups as $group){
            Group::updateOrCreate(
                ['name' => $group['name']],
                []
            );
        }
    }

    private function createGroupsUsers()
    {
        $groups_users = [
            ['name' => 'テストグループ01', 'login' => 'test01'],
            ['name' => 'テストグループ01', 'login' => 'test02'],
            ['name' => 'テストグループ01', 'login' => 'test03'],
            ['name' => 'テストグループ01', 'login' => 'test04'],
            ['name' => 'テストグループ01', 'login' => 'test05'],
            ['name' => 'テストグループ01', 'login' => 'test06'],
            ['name' => 'テストグループ01', 'login' => 'test07'],
            ['name' => 'テストグループ01', 'login' => 'test08'],
            ['name' => 'テストグループ01', 'login' => 'test09'],
            ['name' => 'テストグループ01', 'login' => 'test10'],
            ['name' => 'テストグループ02', 'login' => 'test01'],
            ['name' => 'テストグループ02', 'login' => 'test02'],
            ['name' => 'テストグループ02', 'login' => 'test03'],
            ['name' => 'テストグループ02', 'login' => 'test04'],
            ['name' => 'テストグループ02', 'login' => 'test05'],
            ['name' => 'テストグループ02', 'login' => 'test06'],
            ['name' => 'テストグループ02', 'login' => 'test07'],
            ['name' => 'テストグループ02', 'login' => 'test08'],
            ['name' => 'テストグループ02', 'login' => 'test09'],
            ['name' => 'テストグループ02', 'login' => 'test10'],
            ['name' => 'テストグループ02', 'login' => 'test11'],
            ['name' => 'テストグループ02', 'login' => 'test12'],
            ['name' => 'テストグループ02', 'login' => 'test13'],
            ['name' => 'テストグループ02', 'login' => 'test14'],
            ['name' => 'テストグループ02', 'login' => 'test15'],
            ['name' => 'テストグループ02', 'login' => 'test16'],
            ['name' => 'テストグループ02', 'login' => 'test17'],
            ['name' => 'テストグループ02', 'login' => 'test18'],
            ['name' => 'テストグループ02', 'login' => 'test19'],
            ['name' => 'テストグループ02', 'login' => 'test20'],
            ['name' => 'テストグループ03', 'login' => 'test21'],
            ['name' => 'テストグループ03', 'login' => 'test22'],
            ['name' => 'テストグループ03', 'login' => 'test23'],
            ['name' => 'テストグループ03', 'login' => 'test24'],
            ['name' => 'テストグループ03', 'login' => 'test25'],
            ['name' => 'テストグループ03', 'login' => 'test26'],
            ['name' => 'テストグループ03', 'login' => 'test27'],
            ['name' => 'テストグループ03', 'login' => 'test28'],
            ['name' => 'テストグループ03', 'login' => 'test29'],
            ['name' => 'テストグループ03', 'login' => 'test30'],
        ];

        foreach($groups_users as $group_user){
            $group = Group::whereName($group_user['name'])->first();
            if(is_null($group)){ continue; }
            $user = User::whereLogin($group_user['login'])->first();
            if(is_null($user)){ continue; }
            DB::table('groups_users')->updateOrInsert(
                ['group_id' => $group->id, 'user_id' => $user->id],
                []
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
        $this->createGroups();
        $this->createGroupsUsers();
    }
}
