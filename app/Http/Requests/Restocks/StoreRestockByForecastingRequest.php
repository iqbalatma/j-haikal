<?php

namespace App\Http\Requests\Restocks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRestockByForecastingRequest extends FormRequest
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
            "forecastings" => ["array" ,"min:1"],
            "forecastings.*.id" => [Rule::exists("forecasting", "id")],
            "forecastings.*.quantity" => ["numeric"],
        ];
    }
}
