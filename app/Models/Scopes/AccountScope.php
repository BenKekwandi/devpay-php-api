<?php

namespace App\Models\Scopes;

use App\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AccountScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if(Auth::check()) {
            $userObj = Auth::user();
            if ($userObj && in_array($userObj->type, [UserTypeEnum::ACCOUNT, UserTypeEnum::INTEGRATION])) {
                $builder->where('account_id', $userObj->account_id);
            }
        }
    }
}
