<?php

namespace App\Services;

use App\Enums\Matrix\PinStatus;
use App\Models\PinGenerate;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Str;

class PinGenerateService
{

    /**
     * @param string $pinNumber
     * @return PinGenerate|null
     */
    public function findByPinNumber(string $pinNumber): ?PinGenerate
    {
        return PinGenerate::where('pin_number', $pinNumber)->first();
    }

    /**
     * @param int|string|null $userId
     * @return AbstractPaginator
     */
    public function getPinsByPaginate(int|string $userId = null): AbstractPaginator
    {
        return PinGenerate::filter(\request()->all())
            ->when(!is_null($userId), fn ($query) => $query->where('set_user_id', $userId))
            ->paginate(getPaginate());
    }


    public function prepParams(int $number, int|float|string $amount, int|string|float $charge, string $details): array
    {
        $pins = [];

        for ($i = 1; $i <=$number ; $i++) {
            $pins[] = [
                'uid' => Str::random(),
                'amount' => $amount,
                'pin_number' => $this->generatePinNumber(),
                'details' => $details,
                'charge' => $charge,
                'status' => PinStatus::UNUSED->value,
                'created_at' => carbon(),
            ];
        }

        return $pins;
    }


    /**
     * @param array $pins
     * @return void
     */
    public function save(array $pins): void
    {
        try {
            PinGenerate::insert($pins);
        }catch (\Exception $exception){

        }
    }

    /**
     * @return string
     */
    private function generatePinNumber(): string
    {
        return implode('-', [
            rand(10000000, 99999999),
            rand(10000000, 99999999),
            rand(10000000, 99999999),
            rand(10000000, 99999999),
        ]);
    }

}
