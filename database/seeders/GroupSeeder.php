<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // regist Anonymous Group
        Group::updateOrCreate(
            ['type' => UserType::GROUP_ANONYMOUS],
            [
                'name' => __(UserType::GROUP_ANONYMOUS->string()),
            ]            
        );

        // regist NonMember Group
        Group::updateOrCreate(
            ['type' => UserType::GROUP_NON_MEMBER],
            [
                'name' => __(UserType::GROUP_NON_MEMBER->string()),
            ]            
        );

        // regist NonMember Group
        Group::updateOrCreate(
            ['type' => UserType::ANONYMOUS_USER],
            [
                'name'   => __(UserType::ANONYMOUS_USER->string()),
                'status' => UserStatus::LOCKED,
            ]            
        );
    }
}
