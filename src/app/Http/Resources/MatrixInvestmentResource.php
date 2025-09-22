<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatrixInvestmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'created_at' => showDateTime($this->created_at) ?? null,
            'uid' => $this->id,
            'plan_id' => $this->plan_id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'trx' => $this->trx,
            'price' => $this->price,
            'referral_reward' => $this->referral_reward,
            'referral_commissions' => $this->referral_commissions,
            'level_commissions' => $this->level_commissions,
            'total_profit' => $this->total_profit,
            'meta' => $this->meta,
            'status' => $this->status,
        ];
    }
}
