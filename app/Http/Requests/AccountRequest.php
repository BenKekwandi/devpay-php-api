<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\AccountTypeEnum;
use Illuminate\Validation\Rules\Enum;

class AccountRequest extends FormRequest
{
    /**
     * @return array<mixed>
     */
    public function rules(): array
    {

        return [
            'account_group_id' => ['required', 'exists:account_groups,id'],
            'title' => ['required'],
            'type' => [
                'required',
               new Enum(AccountTypeEnum::class),
            ],
            'is_active' => [
                'boolean'
            ],
        ];
    }
}
