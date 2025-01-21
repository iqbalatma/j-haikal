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
        return [
            "title" => "Transaksi",
            "transactions" => TransactionRepository::with(["product", "supplier"])
                ->orderColumn("transaction_date", "DESC")
                ->getAllDataPaginated()
        ];
    }

}
