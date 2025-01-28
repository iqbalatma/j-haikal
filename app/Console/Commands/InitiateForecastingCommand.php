<?php

namespace App\Console\Commands;

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

    private function samplePrediction(): void
    {
        $alpha = 0.1;
        $forecasting = [
            0 => [
                "actual" => 9000,
                "prediction" => 10_000,
            ],
            1 => [
                "actual" => 11_000,
                "prediction" => 9_900,
            ],
            2 => [
                "actual" => 11_500,
                "prediction" => 10_010,
            ],
            3 => [
                "actual" => 10_000,
                "prediction" => 10_159,
            ],
            4 => [
                "actual" => 9_500,
                "prediction" => 10_143,
            ],
            5 => [
                "actual" => 8_900,
                "prediction" => 10_079,
            ],
            6 => [
                "actual" => 10_000,
                "prediction" => 9_961,
            ],
            7 => [
                "actual" => 11_500,
                "prediction" => 9_965,
            ],
        ];

        foreach ($forecasting as $key => $value) {
            if ($key === 0) {
                $crosscheckPrediction = $value["prediction"];
            } else {
                $crosscheckPrediction = $forecasting[$key - 1]["prediction"] + ($alpha * ($forecasting[$key - 1]["actual"] - $forecasting[$key - 1]["prediction"]));
            }

            $forecasting[$key]["crosscheck_prediction"] = $crosscheckPrediction;
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $alpha = 0.1;
        $this->samplePrediction();
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
                $transaction = Transaction::query()
                    ->select([
                        DB::raw("SUM(quantity) as quantity"),
                    ])
                    ->where("product_id", $product->id)
                    ->whereMonth("transaction_date", $startDate->format("m"))
                    ->whereYear("transaction_date", $startDate->format("Y"))
                    ->first();

                if ($index === 0) {
                    $prediction = $transaction->quantity;
                } else {
                    //prediction = (alpha * actual-index-1) + ((1-alpha) * prediction-index-1)
                    $prediction = ($alpha * $months[$index - 1]["actual"]) + ((1 - $alpha) * $months[$index-1]["prediction"]);
//                    $prediction = $months[$index - 1]["prediction"] + ($alpha * ($months[$index - 1]["actual"] - $months[$index - 1]["prediction"]));
                    #given same result
                }

                $forecasting = [
                    "period" => $period,
                    "product_id" => $product->id,
                    "actual" => $transaction->quantity,
                    "prediction" => round($prediction),
                    "mse" => round($this->getMSE($months),2),
                    "mad" => round($this->getMAD($months),2),
                    "mape" => round($this->getMAPE($months),2),
                ];
                $months[$index] = $forecasting;


                Forecasting::query()->create($forecasting);


                $startDate->addMonth();
                $index++;
            }
        }
    }

    public function getMSE(array $data): float|null
    {
        if (count($data) === 0) {
            return null;
        }
        $collection = collect($data);

        $total = 0;
        foreach ($collection as $item){
            $total += abs($item["actual"] - $item["prediction"]) ** 2;
        }

        return $total / count($collection);
    }

    public function getMAD(array $data): float|null
    {
        if (count($data) === 0) {
            return null;
        }

        $collection = collect($data);

        $total = 0;

        foreach ($collection as $item){
            $total += abs($item["actual"] - $item["prediction"]);
        }

        return $total / count($collection);
    }

    public function getMAPE(array $data): float|null
    {
        if (count($data) === 0) {
            return null;
        }

        $collection = collect($data);

        $total = 0;

        foreach ($collection as $item){
            $total += abs(($item["actual"] - $item["prediction"]) / $item["actual"]) * 100;
        }

        return $total / count($collection);
    }
}
