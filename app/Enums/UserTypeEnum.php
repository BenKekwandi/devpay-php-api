<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case MASTER = 'master';
    case MANAGER = 'manager';
    case ACCOUNT = 'account';
    case INTEGRATION = 'integration';

    public function label(): string
    {
        return match ($this) {
            UserTypeEnum::MASTER => 'master',
            UserTypeEnum::MANAGER => 'manager',
            UserTypeEnum::ACCOUNT => 'account',
            UserTypeEnum::INTEGRATION => 'integration',
        };
    }
}
