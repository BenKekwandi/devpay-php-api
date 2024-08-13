<?php

namespace Tests\Unit\Traits;

use App\Enums\UserTypeEnum;
use Tests\Unit\Model\CreateUserModel;

trait Authenticate
{
    use CreateUser;
    protected function authenticate(): string
    {
        $createUserModel = new CreateUserModel();
        $createUserModel->type = UserTypeEnum::MASTER;
        return $this->createUserAndAuthenticate($createUserModel);
    }
}