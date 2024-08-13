<?php

namespace Tests\Unit\Traits;

use Tests\Unit\Model\CreateAccountModel;
use App\Models\Account;

trait CreateAccount
{
    protected function createAccount(CreateAccountModel $createAccountModel): Account
    {
        return Account::factory()->create([
            'title' => $createAccountModel->title,
            'is_active' => $createAccountModel->isActive,
        ]);
    }
}