<?php

namespace Database\Factories;

use App\Enums\Enums\TransactionType;
use App\Models\Produk;
use App\Models\Suplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "product_id" => Produk::query()->get()->random()->id,
            "supplier_id" => Suplier::query()->get()->random()->id,
            "type" => $this->faker->randomElement(TransactionType::names()),
            "quantity" => $this->faker->numberBetween(1, 100),
            "stock_before" => $this->faker->numberBetween(1, 100),
            "stock_after" => $this->faker->numberBetween(1, 100),
            "created_by_id" => User::query()->get()->random()->id,
            "transaction_date" => Carbon::now()
        ];
    }
}
