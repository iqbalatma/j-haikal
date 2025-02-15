<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Forecasting;
use App\Models\Produk;
use App\Models\Suplier;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Iqbalatma\LaravelServiceRepo\BaseService;

class SaleService extends BaseService
{
    protected $repository;


    public function __construct()
    {
        // $this->repository
    }

    /**
     * @return array
     */
    public function getAllDataPaginated(): array
    {
        $month = request()->input("month", Carbon::now()->month);
        $year = request()->input("year", Carbon::now()->year);

        $query = TransactionRepository::with("product")
            ->where("type", TransactionType::SALE->name)
            ->orderColumn("transaction_date", "DESC")
            ->whereMonth("transaction_date", "=", $month)
            ->whereYear("transaction_date", "=", $year);

        if ($productCode = request()->input("kode_produk")) {
            $query->whereHas("product", function ($query) use ($productCode) {
                return $query->where("kode_produk", $productCode);
            });
        }

        if ($productName = request()->input("nama_produk")) {
            $query->whereHas("product", function ($query) use ($productName) {
                return $query->where("nama_produk", "LIKE", "%$productName%");
            });
        }


        $transactionSummary = Transaction::query()
            ->select([
                DB::raw("count(transactions.id) as total_transaction"),
                DB::raw("count(DISTINCT transactions.product_id) as total_product"),
                DB::raw("count(DISTINCT transactions.supplier_id) as total_supplier"),
                DB::raw("sum(transactions.quantity * produks.harga_satuan) as total_assets"),
            ])
            ->join("produks", "produks.id", "=", "transactions.product_id")
            ->whereMonth("transaction_date", "=", $month)
            ->whereYear("transaction_date", "=", $year)
            ->where("type", TransactionType::SALE->name)
            ->first();

        $transactionByUnit = Transaction::query()
            ->select([
                "produks.satuan",
                DB::raw("count(transactions.id) as total"),
            ])
            ->join("produks", "produks.id", "=", "transactions.product_id")
            ->whereMonth("transaction_date", "=", $month)
            ->whereYear("transaction_date", "=", $year)
            ->where("type", TransactionType::SALE->name)
            ->groupBy("produks.satuan")
            ->get();

        $transactionByDate = Transaction::query()
            ->select([
                DB::raw("DATE(transaction_date) as date"),
                DB::raw("count(transactions.id) as total_transaction"),
                DB::raw("sum(transactions.quantity) as total_quantity"),
            ])
            ->whereMonth("transaction_date", "=", $month)
            ->whereYear("transaction_date", "=", $year)
            ->where("type", TransactionType::SALE->name)
            ->groupBy("date")
            ->get();

        return [
            "title" => "Transactions",
            "sales" => $query->getAllDataPaginated(["type" => TransactionType::SALE->name]),
            "summaries" => [
                "total_transaction" => $transactionSummary->total_transaction,
                "total_product" => $transactionSummary->total_product,
                "total_supplier" => $transactionSummary->total_supplier,
                "total_asset" => formatToRupiah($transactionSummary->total_assets),
                "by_unit" => [
                    "labels" => $transactionByUnit->map(function ($item) {
                        return $item->satuan;
                    }),
                    "values" => $transactionByUnit->map(function ($item) {
                        return $item->total;
                    }),
                ],
                "by_date" => [
                    "labels" => $transactionByDate->pluck("date"),
                    "total_transactions" => $transactionByDate->pluck("total_transaction"),
                    "total_quantities" => $transactionByDate->pluck("total_quantity"),
                ]
            ]
        ];
    }


    /**
     * @return array
     */
    public function getCreateData(): array
    {
        return [
            "products" => Produk::query()->where("quantity", ">", 0)->get(),
            "suppliers" => Suplier::query()->get(),
        ];
    }

    /**
     * @param array $requestedData
     * @return array
     */
    public function addNewData(array $requestedData): array
    {
        try {
            DB::beginTransaction();
            $product = Produk::query()->findOrFail($requestedData["product_id"]);
            if (!$product) {
                DB::rollBack();
                return [
                    "success" => false,
                    "message" => "Produk tidak ditemukan"
                ];
            }
            if ($product?->quantity < $requestedData["quantity"]) {
                DB::rollBack();
                return [
                    "success" => false,
                    "message" => "Kuantitas produk tidak cukup"
                ];
            }
            Transaction::query()->create([
                "product_id" => $requestedData["product_id"],
                "quantity" => $requestedData["quantity"],
                "type" => TransactionType::SALE->name,
                "created_by_id" => Auth::id(),
                "transaction_date" => Carbon::now(),
                "stock_before" => $product?->quantity,
                "stock_after" => $product?->quantity - $requestedData["quantity"],
            ]);

            $product->quantity -= $requestedData["quantity"];
            $product->save();

            $period = Carbon::now()->format("Y-m");

            $forecasting = Forecasting::query()
                ->where("product_id", $product->id)
                ->where("period", $period)
                ->first();

            $forecastings = Forecasting::query()->where("product_id", $product->id)->get();

            if ($forecasting) {
                $forecasting->actual += $requestedData["quantity"];
                $forecasting->mse = round(getMSE($forecastings->toArray()), 2);
                $forecasting->mad = round(getMAD($forecastings->toArray()), 2);
                $forecasting->mape = round(getMAPE($forecastings->toArray()), 2);
                $forecasting->save();
            }

            DB::commit();
            $response = [
                "success" => true
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $response = getDefaultErrorResponse($e);
        }

        return $response;
    }
}
