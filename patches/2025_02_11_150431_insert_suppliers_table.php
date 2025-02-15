<?php

use Dentro\Patcher\Patch;

return new class extends Patch
{
    /**
     * Run patch script.
     *
     * @return void
     */
    public function patch(): void
    {
        $command = $this->command;
        $command->info("START INSERTING DATA SUPPLIER");

        if ($file = fopen(__DIR__ . "/data/suppliers.csv", 'rb')) {
            $command->info("=========================");
            $totalLines = count(file(__DIR__ . "/data/suppliers.csv"));
            $command->withProgressBar($totalLines - 1, function ($bar) use ($file, $command) {
                $count = 1;
                $dataSuppliers = [];
                $now = \Carbon\Carbon::now();
                while (($row = fgetcsv($file, separator: ';')) !== false) {
                    $count++;
                    if ($count === 2) {
                        continue;
                    }

                    $dataSuppliers[] = [
                        "nama_suplier" => getTrimmedOrNull($row[0]),
                        "alamat" => getTrimmedOrNull($row[1]),
                        "created_at" => $now,
                        "updated_at" => $now,
                    ];

                    $bar->advance();
                }
                \Illuminate\Support\Facades\DB::table("supliers")->insert($dataSuppliers);
            });
        }
        $command->info(PHP_EOL . "=========================");
        $command->info("INSERTING DATA SUPPLIER SUCCESSFULLY");
    }
};
