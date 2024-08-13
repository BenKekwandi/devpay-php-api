<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts =Account::get()->all();

        User::factory()->createMany([
            [
                'code' => uniqid(),
                'username' => 'master',
                'type' => UserTypeEnum::MASTER
            ],
            [
                'code' => uniqid(),
                'username' => 'manager',
                'type' => UserTypeEnum::MANAGER
            ],
        ]);


        if (count($accounts)) {
            foreach ($accounts as $account) {

                User::factory(5)->for($account)->createMany(
                    [
                        [
                            'type' => UserTypeEnum::ACCOUNT
                        ],
                        [
                            'type' => UserTypeEnum::INTEGRATION
                        ]
                    ]
                );

            }

        }

    }
}
