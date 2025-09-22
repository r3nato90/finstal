<?php

namespace App\Http\Requests\Ico;

use Illuminate\Foundation\Http\FormRequest;

class TokenRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10|uppercase',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0.01',
            'current_price' => 'nullable|numeric|min:0',
            'total_supply' => 'required|numeric|min:1|max:1000000000000',
            'tokens_sold' => 'nullable|integer|min:0',
            'sale_start_date' => 'required|date',
            'sale_end_date' => 'required|date|after:sale_start_date',
            'status' => 'required|in:active,paused,completed,cancelled',
            'is_featured' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Token name is required.',
            'name.max' => 'Token name cannot exceed 255 characters.',
            'symbol.required' => 'Token symbol is required.',
            'symbol.max' => 'Token symbol cannot exceed 10 characters.',
            'symbol.uppercase' => 'Token symbol must be in uppercase.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'price.required' => 'Initial price is required.',
            'price.min' => 'Initial price must be at least $0.01.',
            'current_price.min' => 'Current price cannot be negative.',
            'total_supply.required' => 'Total supply is required.',
            'total_supply.min' => 'Total supply must be at least 1.',
            'total_supply.max' => 'Total supply cannot exceed 1 trillion tokens.',
            'tokens_sold.min' => 'Tokens sold cannot be negative.',
            'sale_start_date.required' => 'Sale start date is required.',
            'sale_start_date.after_or_equal' => 'Sale start date must be today or later.',
            'sale_end_date.required' => 'Sale end date is required.',
            'sale_end_date.after' => 'Sale end date must be after the start date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be one of: active, paused, completed, or cancelled.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->tokens_sold && $this->total_supply && $this->tokens_sold > $this->total_supply) {
                $validator->errors()->add('tokens_sold', 'Tokens sold cannot exceed total supply.');
            }

            if ($this->current_price && $this->price && $this->current_price > ($this->price * 100)) {
                $validator->errors()->add('current_price', 'Current price seems unreasonably high compared to initial price.');
            }
        });
    }
}
