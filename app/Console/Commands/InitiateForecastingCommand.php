<?php

namespace App\Console\Commands;

use App\Enums\Enums\TransactionType;
use App\Models\Forecasting;
use App\Models\Produk;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitiateForecastingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initiate-forecasting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alpha = 0.1;
        $products = Produk::query()->select("id")->get();
        foreach ($products as $product) {
            /** @var Produk $product */

            $firstTransaction = Transaction::query()
                ->select("transaction_date")
                ->where("product_id", $product->id)
                ->orderBy("transaction_date", "ASC")
                ->first();

            $lastTransaction = Transaction::query()
                ->select("transaction_date")
                ->where("product_id", $product->id)
                ->orderBy("transaction_date", "DESC")
                ->first();

            $startDate = Carbon::parse($firstTransaction->transaction_date)->startOfMonth();
            $endDate = Carbon::parse($lastTransaction->transaction_date)->endOfMonth();

            $months = [];

            $index = 0;
            while ($startDate->lte($endDate)) {
                $period = $startDate->format('Y-m');

                #currentTransaction
                $currentTransactions = Transaction::query()
                    ->select([
                        DB::raw("SUM(quantity) as quantity"),
                    ])
                    ->where("product_id", $product->id)
                    ->where('type', TransactionType::SALE->name)
                    ->whereMonth("transaction_date", $startDate->format("m"))
                    ->whereYear("transaction_date", $startDate->format("Y"))
                    ->first();

                if ($index === 0) {
                    $prediction = $currentTransactions->quantity;
                } else {
                    //prediction = (alpha * actual-index-1) + ((1-alpha) * prediction-index-1)
                    $prediction = ($alpha * $months[$index - 1]["actual"]) + ((1 - $alpha) * $months[$index - 1]["prediction"]);
//                    $prediction = $months[$index - 1]["prediction"] + ($alpha * ($months[$index - 1]["actual"] - $months[$index - 1]["prediction"]));
                    #given same result
                }


                $initiateRange = $startDate->copy()->subMonths(12);
                $lastRange = $startDate->copy()->subMonths(1);

                $transactions = Transaction::query()
                    ->select([
                        DB::raw("SUM(quantity) as quantity"),
                        DB::raw('YEAR(transaction_date) as year'),
                        DB::raw('MONTH(transaction_date) as month'),
                    ])
                    ->where("product_id", $product->id)
                    ->where('type', TransactionType::SALE->name)
                    ->whereBetween('transaction_date', [
                        $initiateRange->startOfMonth()->toDateString(),
                        $lastRange->endOfMonth()->toDateString(),
                    ])
                    ->groupBy(DB::raw('YEAR(transaction_date), MONTH(transaction_date)'))
                    ->orderBy(DB::raw('YEAR(transaction_date), MONTH(transaction_date)'))
                    ->get();


                $safetyStock = round(getSafetyStock($transactions), 0);
                $forecasting = [
                    "period" => $period,
                    "product_id" => $product->id,
                    "actual" => $currentTransactions->quantity,
                    "actual_restock" => 0,
                    "prediction" => round($prediction, 0),
                    "safety_stock" => $safetyStock,
                    "purchasing_plan" => round(round($prediction, 0) + $safetyStock - $product->quantity, 0),
                    "mse" => round(getMSE($months), 2),
                    "mad" => round(getMAD($months), 2),
                    "mape" => round(getMAPE($months), 2 ),
                ];
                $months[$index] = $forecasting;


                Forecasting::query()->create($forecasting);


                $startDate->addMonth();
                $index++;
            }
        }
    }


}
