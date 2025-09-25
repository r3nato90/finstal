<?php

namespace App\Services\Ico;

use App\Enums\Status;
use App\Models\IcoToken;
use Illuminate\Http\Request;

class TokenService
{
    public function getByPaginate()
    {
        return IcoToken::latest()->paginate(getPaginate());
    }

    public function getToken()
    {
        return IcoToken::select('id', 'name', 'symbol')->get();
    }

    public function findById(int|string $id)
    {
        return IcoToken::where('id', $id)->first();
    }

    public function prepParams(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'symbol' => $request->input('symbol'),
            'description' => $request->input('description'),
            'total_supply' => $request->input('total_supply'),
            'price' => $request->input('price'),
            'current_price' => $request->input('current_price', 0),
            'tokens_sold' => $request->input('tokens_sold', 0),
            'sale_start_date' => $request->input('sale_start_date'),
            'sale_end_date' => $request->input('sale_end_date'),
            'status' => $request->input('status', Status::ACTIVE->value),
            'is_featured' => $request->has('is_featured') ? 1 : 0,
        ];
    }

    public function save(array $data): IcoToken
    {
        return IcoToken::create($data);
    }

    public function update(IcoToken $token, array $data): IcoToken
    {
        $token->update($data);
        return $token->refresh();
    }

    public function getActiveTokens()
    {
        return IcoToken::where('status', Status::ACTIVE->value)->get();
    }

    public function getFeaturedTokens()
    {
        return IcoToken::where('is_featured', 1)
            ->where('status', Status::ACTIVE->value)
            ->get();
    }

    public function getTokensForSale()
    {
        return IcoToken::where('status', Status::ACTIVE->value)
            ->where('sale_start_date', '<=', now())
            ->where('sale_end_date', '>=', now())
            ->get();
    }

    public function updateTokensSold(IcoToken $token, int $quantity): IcoToken
    {
        $token->increment('tokens_sold', $quantity);
        return $token->refresh();
    }

    public function calculateProgress(IcoToken $token): float
    {
        if ($token->total_supply <= 0) {
            return 0;
        }

        return ($token->tokens_sold / $token->total_supply) * 100;
    }

    public function calculateRemainingTokens(IcoToken $token): int
    {
        return max(0, $token->total_supply - $token->tokens_sold);
    }

    public function isTokenSaleActive(IcoToken $token): bool
    {
        $now = now();
        return $token->status === 'active'
            && $token->sale_start_date <= $now
            && $token->sale_end_date >= $now;
    }

    public function getTotalRaised(IcoToken $token): float
    {
        return $token->tokens_sold * $token->price;
    }

    public function getMaximumRaise(IcoToken $token): float
    {
        return $token->total_supply * $token->price;
    }
}
