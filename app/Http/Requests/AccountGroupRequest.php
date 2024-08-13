<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountGroupRequest extends FormRequest
{
    /**
     * @return array<mixed>
     */
    public function rules(): array
    {
        
        return [
            'title' => ['required'],
            'is_active' => ['boolean'],
        ];
    }
}
