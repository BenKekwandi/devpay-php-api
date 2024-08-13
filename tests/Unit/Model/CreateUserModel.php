<?php

namespace Tests\Unit\Model;

use App\Enums\UserTypeEnum;

class CreateUserModel
{

    public ?string $username = null;

    public bool $accountBinding = true;

    public bool $isUserActive = true;

    public bool $isAccountActive = true;

    public bool $isAccountGroupActive = true;

    public UserTypeEnum $type = UserTypeEnum::ACCOUNT;

    public string $password = 'password';

}