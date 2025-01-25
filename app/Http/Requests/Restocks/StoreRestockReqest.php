<?php

namespace App\Http\Requests\Restocks;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRestockReqest extends FormRequest
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
            "product_id" => ["required", Rule::exists("produks", "id")],
            "supplier_id" => ["required", Rule::exists("supliers", "id")],
            "quantity" => ["required", "numeric", "min:1"],
        ];
    }
}
