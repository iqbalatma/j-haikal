<?php

namespace App\Services;

use App\Enums\Enums\TransactionType;
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
        return [
            "title" => "Transactions",
            "sales" => TransactionRepository::with("product")
                ->orderColumn("transaction_date", "DESC")
                ->getAllDataPaginated(["type" => TransactionType::SALE->name])
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

            if (!$product){
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
                "supplier_id" => $requestedData["supplier_id"],
                "quantity" => $requestedData["quantity"],
                "type" => TransactionType::SALE->name,
                "created_by_id" => Auth::id(),
                "transaction_date" => Carbon::now(),
                "stock_before" => $product?->quantity,
                "stock_after" => $product?->quantity - $requestedData["quantity"],
            ]);

            $product->quantity -= $requestedData["quantity"];
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
}
