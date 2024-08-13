<?php

namespace App\Http\Resources;

use App\Models\AccountPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AccountPaymentMethod */

class AccountPaymentMethodResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<mixed, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'payment_method_id' => $this->payment_method_id,
            'account_id' => $this->account_id,
            'remark' => $this->remark,
            'is_active' => $this->is_active,
        ];
    }
}
