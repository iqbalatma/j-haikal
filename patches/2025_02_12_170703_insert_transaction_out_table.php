<?php

use App\Enums\TransactionType;
use App\Models\Produk;
use App\Models\Transaction;
use Carbon\Carbon;
use Dentro\Patcher\Patch;
use Illuminate\Support\Facades\DB;

return new class extends Patch {
    /**
     * Run patch script.
     *
     * @return void
     */
    public function patch(): void
    {
        $command = $this->command;
        $command->info("START INSERTING DATA TRANSACTIONS");

        if ($file = fopen(__DIR__ . "/data/transactions_out.csv", 'rb')) {
            $command->info("=========================");
            $totalLines = count(file(__DIR__ . "/data/transactions_out.csv"));
            $command->withProgressBar($totalLines - 1, function ($bar) use ($file, $command) {
                $count = 1;
                $now = \Carbon\Carbon::now();
                while (($row = fgetcsv($file, separator: ';')) !== false) {
                    $count++;
                    if ($count === 2) {
                        continue;
                    }
                    DB::beginTransaction();
                    $product = Produk::query()->where("kode_produk", getTrimmedOrNull($row[1]))->first();
                    if (!$product) {
                        $command->warn("Product code " . $row[1] . " not found");
                        DB::rollBack();
                        continue;
                    }

                    $product->quantity -= getTrimmedOrNull($row[7]);
                    $product->save();

                    $period = Carbon::createFromFormat("Y-m", getTrimmedOrNull($row[6]))?->startOfMonth();
                    Transaction::query()->create([
                        "product_id" => $product->id,
                        "supplier_id" => null,
                        "type" => TransactionType::SALE->name,
                        "quantity" => getTrimmedOrNull($row[7]),
                        "stock_before" => null,
                        "stock_after" => null,
                        "created_by_id" => null,
                        "transaction_date" => $period
                    ]);

                    DB::commit();

                    $bar->advance();
                }
            });
        }
        $command->info(PHP_EOL . "=========================");
        $command->info("INSERTING DATA TRANSACTIONS OUT SUCCESSFULLY");
    }
};
