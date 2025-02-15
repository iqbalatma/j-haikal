<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Forecasting;
use App\Models\Produk;
use App\Models\Suplier;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Iqbalatma\LaravelServiceRepo\BaseService;

class RestockService extends BaseService
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
        return [
            "title" => "Restok",
            "products" => Produk::query()->get()
        ];
    }

    /**
     * @return array
     */
    public function restockForForecasting(): array
    {
        $forecastings = collect();
        if ($period = request()->input("period")) {
            $forecastings = Forecasting::query()->with("product")->where("period", $period)->whereNull("actual_restock")->paginate();
        }
        return [
            "title" => "Restok",
            "forecastings" => $forecastings,
            "suppliers" => Suplier::query()->get(),
            "products" => Produk::query()->get()
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

            Transaction::query()->create([
                "product_id" => $requestedData["product_id"],
                "supplier_id" => $requestedData["supplier_id"],
                "quantity" => $requestedData["quantity"],
                "type" => TransactionType::RESTOCK->name,
                "created_by_id" => Auth::id(),
                "transaction_date" => Carbon::now(),
                "stock_before" => $product?->quantity,
                "stock_after" => $product?->quantity + $requestedData["quantity"],
            ]);

            $product->quantity += $requestedData["quantity"];
            $product->save();
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

    /**
     * @param array $requestedData
     * @return array
     */
    public function restockByForecasting(array $requestedData): array
    {
        // forecasting 1 produknya MGS => purchasing plan 60 => actual restock 55
        try {
            DB::beginTransaction();
            foreach ($requestedData["forecastings"] as $forecasting) {
                //ini untuk update forecasting actual stock
                /** @var Forecasting $forecastingFromDB */
                $forecastingFromDB = Forecasting::query()->findOrFail($forecasting["id"]);
                $forecastingFromDB->actual_restock = $forecasting["quantity"];
                $forecastingFromDB->save();


                //ini untuk update kuantitas produk
                /** @var Produk $productFromDB */
                $productFromDB = Produk::query()->findOrFail($forecastingFromDB->product_id);
                $stockBefore = $productFromDB->quantity;
                $productFromDB->quantity += $forecasting["quantity"];
                $stockAfter = $productFromDB->quantity;
                $productFromDB->save();


                //ini untuk menambahkan transaksi
                Transaction::query()->create([
                    "product_id" => $productFromDB->id,
                    "supplier_id" => $forecasting["supplier_id"],
                    "quantity" => $forecasting["quantity"],
                    "type" => TransactionType::RESTOCK->name,
                    "created_by_id" => Auth::id(),
                    "transaction_date" => Carbon::now(),
                    "stock_before" => $stockBefore,
                    "stock_after" => $stockAfter
                ]);
            }
            DB::commit();
            $response = [
                "success" => true,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            $response = getDefaultErrorResponse($e);
        }

        return $response;

    }
}
