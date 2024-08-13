<?php

namespace Tests\Unit\Model;

use App\Enums\AccountTypeEnum;
use App\Enums\UserTypeEnum;


class CreateAccountModel
{

    public string $title = 'Account Title';

    public AccountTypeEnum $type = AccountTypeEnum::ACCOUNT;
    public int $accountGroupId;

    public bool $isActive = true;


}