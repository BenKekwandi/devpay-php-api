<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            'username' => ['required','min:5','max:20'],
            'password' => ['required', 'string','min:6']
        ];
    }
}
