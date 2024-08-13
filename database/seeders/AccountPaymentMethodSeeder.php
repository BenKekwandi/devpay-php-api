<?php

namespace Database\Seeders;

use App\Models\AccountPaymentMethod;
use Illuminate\Database\Seeder;

class AccountPaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = \DB::table('accounts')->pluck('id')->all();
        $paymentMethods = \DB::table('payment_methods')->pluck('id')->all();

        foreach ($accounts as $accountId) {

            foreach ($paymentMethods as $paymentMethodId) {

                AccountPaymentMethod::factory(1)->create([
                    'account_id' => $accountId,
                    'payment_method_id' => $paymentMethodId,
                ]);

            }
        }

    }
}
