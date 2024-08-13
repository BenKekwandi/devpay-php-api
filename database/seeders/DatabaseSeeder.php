<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PaymentMethodSeeder::class,
            AccountGroupSeeder::class,
            AccountSeeder::class,
            UserSeeder::class,
            AccountPaymentMethodSeeder::class,
        ]);
    }
}
