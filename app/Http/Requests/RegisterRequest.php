<?php

namespace App\Http\Requests;

use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    /**
     * @return array<mixed>
     */
    public function rules(): array
    {

        return [
            'account_id' => ['required','integer','exists:accounts,id'],
            'type' => ['required', new Enum(UserTypeEnum::class)],
            'name' => ['required','string','max:255'],
            'lastname' => ['required','string','max:255'],
            'email' => ['required','email'],
            'username' => ['required','string','min:5','max:20','unique:users,username,account_id'],
            'password' => ['required', 'string','min:6'],
            'repeated_password' => ['required', 'same:password'],
            'phone' => ['nullable','string','max:255'],
            'is_active' => ['boolean'],
        ];
    }
}
