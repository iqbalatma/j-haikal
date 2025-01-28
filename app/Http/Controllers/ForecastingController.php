<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastingController extends Controller
{
    public function index()
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

        $nextForecasting = $forecasting[0]["prediction"] + ($alpha * ($forecasting[0]["actual"] - $forecasting[0]["prediction"]));
        dd($nextForecasting);
        dd($forecasting);
//        $product = Produk::query()->first();
//        $qJanuary = Transaction::query()
//            ->select([
//                DB::raw("SUM(quantity) as quantity"),
//            ])
//            ->whereMonth("transaction_date", 1)
//            ->whereYear("transaction_date", 2025)
//            ->where("product_id", $product->id)
//            ->first();
//        $alpha = 0.1;
//
//        $forecasting = [
//            "01-2025" => [
//                "actual" => $qJanuary->quantity,
//                "prediction" => null,
//                "mad" => null,
//                "mse" => null,
//                "mape" => null
//            ],
//        ];
//
//        dd($forecasting);
//
//        dd($dataTransactions);
//        dd(":s");
    }
}
