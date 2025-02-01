<?php

namespace App\Services;

use App\Models\Forecasting;
use App\Models\Produk;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Iqbalatma\LaravelServiceRepo\BaseService;

class ForecastingService extends BaseService
{
    protected $repository;
    protected float $alpha;

    public function __construct()
    {
        $this->alpha = 0.1;
        // $this->repository
    }

    /**
     * @return array
     */
    public function getAllDataPaginated(): array
    {
        $query = Forecasting::query()->orderBy("period", "DESC");
        if ($period = request()->input("period")) {
            $query->where("period", $period);
        }

        if ($productCode = request()->input("kode_produk")) {
            $query->whereHas("product", function ($query) use ($productCode) {
                $query->where("kode_produk", $productCode);
            });
        }

        $forecastingByProduct = null;
        if ($productId = request()->input("product_id")) {
            $forecastingByProduct = Forecasting::query()
                ->where("product_id", $productId)
                ->orderBy("period", "ASC")
                ->get();
            $forecastingByProduct = [
                "labels" => $forecastingByProduct->pluck("period")->toArray(),
                "predictions" => $forecastingByProduct->pluck("prediction")->toArray(),
                "actual" => $forecastingByProduct->pluck("actual")->toArray(),
                "mape" => $forecastingByProduct->pluck("mape")->toArray(),
            ];
        }
        return [
            "products" => Produk::query()->get(),
            "forecastings" => $query->paginate(25),
            "forecastingByProduct" => $forecastingByProduct
        ];
    }

    /**
     * @param array $requestedData
     * @return true[]
     */
    public function addNewData(array $requestedData): array
    {
        try {
            $products = Produk::query()->select("id")->get();
            $now = Carbon::createFromFormat("Y-m", $requestedData["year"] . "-" . $requestedData["month"])?->startOfMonth();
            $previous = Carbon::createFromFormat("Y-m", $requestedData["year"] . "-" . $requestedData["month"])?->startOfMonth()->subMonth();
            foreach ($products as $product) {
                /** @var Produk $product */
                $previousForecasting = Forecasting::query()
                    ->where("product_id", $product->id)
                    ->where("period", $previous->format("Y-m"))
                    ->first();

                $currentTransactions = Transaction::query()
                    ->select([
                        DB::raw("SUM(quantity) as quantity"),
                    ])
                    ->where("product_id", $product->id)
                    ->whereMonth("transaction_date", $now->format("m"))
                    ->whereYear("transaction_date", $now->format("Y"))
                    ->first();

                if (!$previousForecasting) {
                    $prediction = $currentTransactions->quantity;
                } else {
                    $prediction = ($this->alpha * $previousForecasting->actual) + ((1 - $this->alpha) * $previousForecasting->prediction);
                }

                $forecastingByProduct = Forecasting::query()
                    ->where("product_id", $product->id)
                    ->whereNot("period", $now->format("Y-m"))
                    ->get();

                $forecasting = [
                    "period" => $now->format("Y-m"),
                    "product_id" => $product->id,
                    "actual" => $currentTransactions->quantity,
                    "prediction" => round($prediction),
                    "mse" => round(getMSE($forecastingByProduct->toArray()), 2),
                    "mad" => round(getMAD($forecastingByProduct->toArray()), 2),
                    "mape" => round(getMAPE($forecastingByProduct->toArray()), 2),
                ];


                Forecasting::query()
                    ->updateOrCreate(
                        [
                            "period" => $now->format("Y-m"),
                            "product_id" => $product->id
                        ],
                        $forecasting
                    );
            }

            $response = [
                "success" => true,
            ];
        } catch (Exception $e) {
            $response = getDefaultErrorResponse($e);
        }


        return $response;
    }
}
