<?php

namespace Database\Seeders;

use App\Enums\AccountTypeEnum;
use App\Models\Account;
use App\Models\AccountGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $accountGroups = AccountGroup::get()->all();

        if(count($accountGroups)> 0)
        {
            foreach($accountGroups as $accountGroup)
            {
                Account::factory(5)->for($accountGroup)->create([
                    'type' => $faker->randomElement(AccountTypeEnum::cases()),
                ]);
            }
        }


    }
}
