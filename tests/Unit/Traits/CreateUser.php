<?php

namespace Tests\Unit\Traits;

use App\Models\AccountGroup;
use App\Models\Account;
use App\Models\User;
use Tests\Unit\Model\CreateUserModel;
use Tests\Unit\Model\CreateAccountModel;


trait CreateUser
{
    use CreateAccount;

    protected function createUser(CreateUserModel $createUserModel): User
    {

        $accountId = null;
        if($createUserModel->accountBinding === true) {

            $accountGroup = AccountGroup::factory()->create([
                'is_active' => $createUserModel->isAccountGroupActive
            ]);

            $createAccountModel = new CreateAccountModel();
            $createAccountModel->accountGroupId = $accountGroup->id;
            $createAccountModel->isActive = $createUserModel->isAccountActive;
            $account = $this->createAccount($createAccountModel);

            $accountId = $account->id;
        }

        return User::factory()->create([
            'account_id' => $accountId,
            'is_active' => $createUserModel->isUserActive,
            'type' => $createUserModel->type,
            'password' => $createUserModel->password
        ]);

    }

    protected function createUserAndAuthenticate(CreateUserModel $createUserModel): ?string
    {
        $user = $this->createUser($createUserModel);
        $response = $this->postJson('api/login', [
            "username"=> $user->username,
            "password"=> $createUserModel->password
        ]);

        $responseData = $response->json();

        if ($responseData && array_key_exists('token', $responseData) && !empty($responseData['token'])) {
            return $responseData['token'];
        }

        return null;
    }


}