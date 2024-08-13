<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountPaymentMethod;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccountPaymentMethodFactory extends Factory
{
    protected $model = AccountPaymentMethod::class;

    public function definition(): array
    {
        return [
            'code' => uniqid(),
            'title' => $this->faker->lexify('Account Payment Method - ????'),
            'payment_method_id' => PaymentMethod::inRandomOrder()->first()['id'],
            'is_active' => true,
            'remark' => $this->faker->text(100),
            'account_id' => Account::inRandomOrder()->first()['id'],
        ];
    }
}
