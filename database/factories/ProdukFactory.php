<?php

namespace Database\Factories;

use App\Enums\Enums\Type;
use App\Enums\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "kode_produk" => Str::random(),
            "nama_produk" =>"Produk " . $this->faker->name(),
            "jenis_produk" => $this->faker->randomElement(Type::names()),
            "satuan" => $this->faker->randomElement(Unit::names()),
            "harga_satuan" => $this->faker->numberBetween(1, 100),
            "quantity" => $this->faker->numberBetween(1, 100)
        ];
    }
}
