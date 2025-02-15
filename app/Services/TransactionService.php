<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Iqbalatma\LaravelServiceRepo\BaseService;

class TransactionService extends BaseService
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
        $query = TransactionRepository::with(["product", "supplier"])
            ->orderColumn("transaction_date", "DESC");

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


        if ($month = request()->input("month")) {
            $query->whereMonth("transaction_date", "=", $month);
        }


        if ($year = request()->input("year")) {
            $query->whereYear("transaction_date", "=", $year);
        }



        return [
            "title" => "Transaksi",
            "transactions" => $query->getAllDataPaginated()
        ];
    }

}
