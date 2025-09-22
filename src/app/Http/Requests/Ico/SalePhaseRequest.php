<?php

namespace App\Http\Requests\Ico;

use App\Enums\Phase\PhaseType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalePhaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => ['required', Rule::in(PhaseType::values())],
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'token_price' => 'required|numeric|min:0',
            'max_purchase' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0|lt:max_purchase',
            'available_tokens' => 'required|numeric|min:0',
            'enable_dynamic_pricing' => 'boolean',
            'min_price' => 'required_if:enable_dynamic_pricing,true|numeric|nullable|min:0',
            'max_price' => 'required_if:enable_dynamic_pricing,true|numeric|nullable|gt:min_price',
            'price_adjustment_factor' => 'required_if:enable_dynamic_pricing,true|numeric|between:0,1'
        ];
    }
}
