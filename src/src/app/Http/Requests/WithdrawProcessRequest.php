<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WithdrawProcessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'integer',
                Rule::exists('withdraw_methods', 'id')->where(function ($query) {
                    $query->where('status', Status::ACTIVE->value);
                })
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99',
                'decimal:0,8'
            ],
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'id.required' => 'Please select a withdrawal method.',
            'id.exists' => 'The selected withdrawal method is not available.',
            'amount.required' => 'Please enter the withdrawal amount.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The minimum withdrawal amount is :min.',
            'amount.max' => 'The maximum withdrawal amount is :max.',
            'amount.decimal' => 'The amount format is invalid.',
        ];
    }
}
