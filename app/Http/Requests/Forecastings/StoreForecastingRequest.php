<?php

namespace App\Http\Requests\Forecastings;

use Illuminate\Foundation\Http\FormRequest;

class StoreForecastingRequest extends FormRequest
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
            "month" => ["required", "numeric", "min:1", "max:12"],
            "year" => ["required", "numeric", "min:2024", "max:2030"],
        ];
    }
}
