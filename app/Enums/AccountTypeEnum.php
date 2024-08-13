<?php

namespace App\Enums;

enum AccountTypeEnum: string
{
    case RESELLER = 'reseller';
    case ACCOUNT = 'account';


    public function label(): string
    {
        return match ($this) {
            AccountTypeEnum::RESELLER => 'reseller',
            AccountTypeEnum::ACCOUNT => 'account',
        };
    }

}
