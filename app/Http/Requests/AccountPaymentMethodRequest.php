<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AccountPaymentMethodRequest extends FormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'payment_method_id' => ['required','integer','exists:payment_methods,id'],
            'account_id' => ['required','integer','exists:accounts,id'],
            'remark' => ['required','string','max:255'],
            'is_active' => ['boolean'],
        ];
    }
}
