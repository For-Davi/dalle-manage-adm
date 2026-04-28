<?php

namespace App\Http\Resources\Enterprise;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class EnterprisePaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $ref = str($this->external_reference);
        $subscriptionName = DB::connection('dalle_manage')->table('subscriptions')->where('id', $ref->after('subscription_')->before('|'))->first()->name;

        return [
            'id' => $this->id,
            'status' => $this->status,
            'enterprise_name' => $this->user->enterprise->name,
            'enterprise_email' => $this->user->enterprise->email,
            'payment_type' => $this->billing_type,
            'subscription' => $subscriptionName,
            'month_qnty' => (int) $ref->afterLast('_')->toString(),
            'created_at' => $this->created_at
        ];
    }
}
