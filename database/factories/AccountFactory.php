<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountGroup;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\AccountTypeEnum;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->company(),
            'type' => AccountTypeEnum::ACCOUNT,
            'is_active' => true,
            'account_group_id' => AccountGroup::inRandomOrder()->first()['id'],
            'code' => uniqid(),
        ];
    }
}
