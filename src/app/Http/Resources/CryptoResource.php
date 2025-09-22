<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CryptoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'file' => $this->image_url,
            'pair' => $this->tradingview_symbol,
            'price' => shortAmount($this->current_price),
            'market_cap' => showDateTime($this->market_cap),
            'previous_price' => shortAmount($this->previous_price),
            'last_updated' => showDateTime($this->last_updated),
        ];
    }
}
