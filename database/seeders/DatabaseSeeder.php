<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'administrator',
            'email' => 'administrator@example.com',
            "role" => Role::ADMINISTRATOR->name
        ]);

        User::factory()->create([
            'name' => 'kepalagudang',
            'email' => 'kepalagudang@example.com',
            "role" => Role::KEPALA_GUDANG->name
        ]);
        User::factory()->create([
            'name' => 'kepalagudang',
            'email' => 'kepalatoko@example.com',
            "role" => Role::KEPALA_TOKO->name
        ]);

        $this->call([
//            ProdukSeeder::class,
//            SuplierSeeder::class,
//            TransactionSeeder::class
        ]);
    }
}
