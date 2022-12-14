<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Group;
use App\Models\Project;
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
            ['name' => 'テストユーザー21', 'login' => 'test21', 'email' => 'test21@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー22', 'login' => 'test22', 'email' => 'test22@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー23', 'login' => 'test23', 'email' => 'test23@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー24', 'login' => 'test24', 'email' => 'test24@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー25', 'login' => 'test25', 'email' => 'test25@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー26', 'login' => 'test26', 'email' => 'test26@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー27', 'login' => 'test27', 'email' => 'test27@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー28', 'login' => 'test28', 'email' => 'test28@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー29', 'login' => 'test29', 'email' => 'test29@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー30', 'login' => 'test30', 'email' => 'test30@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー31', 'login' => 'test31', 'email' => 'test31@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー32', 'login' => 'test32', 'email' => 'test32@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー33', 'login' => 'test33', 'email' => 'test33@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー34', 'login' => 'test34', 'email' => 'test34@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー35', 'login' => 'test35', 'email' => 'test35@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー36', 'login' => 'test36', 'email' => 'test36@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー37', 'login' => 'test37', 'email' => 'test37@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー38', 'login' => 'test38', 'email' => 'test38@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー39', 'login' => 'test39', 'email' => 'test39@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー40', 'login' => 'test40', 'email' => 'test40@example.com', 'status' => UserStatus::ACTIVE,    'must_change_password' => true, ],
            ['name' => 'テストユーザー41', 'login' => 'test41', 'email' => 'test41@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー42', 'login' => 'test42', 'email' => 'test42@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー43', 'login' => 'test43', 'email' => 'test43@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー44', 'login' => 'test44', 'email' => 'test44@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー45', 'login' => 'test45', 'email' => 'test45@example.com', 'status' => UserStatus::REGISTERD, 'must_change_password' => true, ],
            ['name' => 'テストユーザー46', 'login' => 'test46', 'email' => 'test46@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー47', 'login' => 'test47', 'email' => 'test47@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー48', 'login' => 'test48', 'email' => 'test$8@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー49', 'login' => 'test49', 'email' => 'test49@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
            ['name' => 'テストユーザー50', 'login' => 'test50', 'email' => 'test50@example.com', 'status' => UserStatus::LOCKED,    'must_change_password' => true, ],
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

    private function createProjects()
    {
        $projects = [
            [ 'name' => 'テストプロジェクト01',     'description' => '', 'parent' => null ],
            [ 'name' => 'テストプロジェクト0101',   'description' => '', 'parent' => 'テストプロジェクト01'],
            [ 'name' => 'テストプロジェクト010101', 'description' => '', 'parent' => 'テストプロジェクト0101'],
            [ 'name' => 'テストプロジェクト010102', 'description' => '', 'parent' => 'テストプロジェクト0101'],
            [ 'name' => 'テストプロジェクト0102',   'description' => '', 'parent' => 'テストプロジェクト01'],
            [ 'name' => 'テストプロジェクト010201', 'description' => '', 'parent' => 'テストプロジェクト0102'],
            [ 'name' => 'テストプロジェクト010202', 'description' => '', 'parent' => 'テストプロジェクト0102'],
            [ 'name' => 'テストプロジェクト0103',   'description' => '', 'parent' => 'テストプロジェクト01'],
            [ 'name' => 'テストプロジェクト02',     'description' => '', 'parent' => null ],
            [ 'name' => 'テストプロジェクト0201',   'description' => '', 'parent' => 'テストプロジェクト02'],
            [ 'name' => 'テストプロジェクト0202',   'description' => '', 'parent' => 'テストプロジェクト02'],
            [ 'name' => 'テストプロジェクト0203',   'description' => '', 'parent' => 'テストプロジェクト02'],
            [ 'name' => 'テストプロジェクト020301', 'description' => '', 'parent' => 'テストプロジェクト0203'],
            [ 'name' => 'テストプロジェクト020302', 'description' => '', 'parent' => 'テストプロジェクト0203'],
            [ 'name' => 'テストプロジェクト020303', 'description' => '', 'parent' => 'テストプロジェクト0203'],
            [ 'name' => 'テストプロジェクト020304', 'description' => '', 'parent' => 'テストプロジェクト0203'],
            [ 'name' => 'テストプロジェクト0204',   'description' => '', 'parent' => 'テストプロジェクト02'],
            [ 'name' => 'テストプロジェクト020401', 'description' => '', 'parent' => 'テストプロジェクト0204'],
            [ 'name' => 'テストプロジェクト020402', 'description' => '', 'parent' => 'テストプロジェクト0204'],
            [ 'name' => 'テストプロジェクト020403', 'description' => '', 'parent' => 'テストプロジェクト0204'],
            [ 'name' => 'テストプロジェクト020404', 'description' => '', 'parent' => 'テストプロジェクト0204'],
            [ 'name' => 'テストプロジェクト03',     'description' => '', 'parent' => null ],
            [ 'name' => 'テストプロジェクト0301',   'description' => '', 'parent' => 'テストプロジェクト03'],
            [ 'name' => 'テストプロジェクト0302',   'description' => '', 'parent' => 'テストプロジェクト03'],
            [ 'name' => 'テストプロジェクト0303',   'description' => '', 'parent' => 'テストプロジェクト03'],
            [ 'name' => 'テストプロジェクト0304',   'description' => '', 'parent' => 'テストプロジェクト03'],
            [ 'name' => 'テストプロジェクト0305',   'description' => '', 'parent' => 'テストプロジェクト03'],
            [ 'name' => 'テストプロジェクト04',     'description' => '', 'parent' => null ],
            [ 'name' => 'テストプロジェクト05',     'description' => '', 'parent' => null ],
            [ 'name' => 'テストプロジェクト0501',   'description' => '', 'parent' => 'テストプロジェクト05'],
            [ 'name' => 'テストプロジェクト0502',   'description' => '', 'parent' => 'テストプロジェクト05'],
            [ 'name' => 'テストプロジェクト0503',   'description' => '', 'parent' => 'テストプロジェクト05'],
            [ 'name' => 'テストプロジェクト06',     'description' => '', 'parent' => null ],
        ];

        foreach($projects as $project)
        {
            $project['parent_id'] = null;
            $query = Project::whereName($project['parent']);
            if($query->exists()){
                $project['parent_id'] = $query->first()->id;
            }
            unset($project['parent']);
            Project::updateOrCreate(
                ['name' => $project['name']],
                $project
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
        $this->createProjects();
    }
}
