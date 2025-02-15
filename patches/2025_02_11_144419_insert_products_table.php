<?php

use Dentro\Patcher\Patch;
use Illuminate\Support\Str;

return new class extends Patch {
    /**
     * Run patch script.
     *
     * @return void
     */
    public function patch(): void
    {
        $command = $this->command;
        $command->info("START INSERTING DATA PRODUCTS");

        if ($file = fopen(__DIR__ . "/data/products.csv", 'rb')) {
            $command->info("=========================");
            $totalLines = count(file(__DIR__ . "/data/products.csv"));
            $command->withProgressBar($totalLines - 1, function ($bar) use ($file, $command) {
                $count = 1;
                $dataProducts = [];
                $now = \Carbon\Carbon::now();
                while (($row = fgetcsv($file, separator: ';')) !== false) {
                    $count++;
                    if ($count === 2) {
                        continue;
                    }

                    $dataProducts[] = [
                        "kode_produk" => getTrimmedOrNull($row[1]),
                        "nama_produk" => getTrimmedOrNull($row[2]),
                        "jenis_produk" => strtoupper(getTrimmedOrNull($row[3])),
                        "satuan" => strtoupper(getTrimmedOrNull($row[4])),
                        "hpp" => (int)str_replace(["Rp", "."], "", getTrimmedOrNull($row[5])),
                        "harga_satuan" => (int)str_replace(["Rp", "."], "", getTrimmedOrNull($row[6])),
                        "quantity" => 0,
                        "created_at" => $now,
                        "updated_at" => $now,
                    ];

                    $bar->advance();
                }
                \Illuminate\Support\Facades\DB::table("produks")->insert($dataProducts);
            });
        }
        $command->info(PHP_EOL . "=========================");
        $command->info("INSERTING DATA PRODUCTS SUCCESSFULLY");
    }
};
