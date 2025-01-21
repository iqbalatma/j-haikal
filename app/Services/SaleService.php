<?php

namespace App\Services;

use App\Enums\Enums\TransactionType;
use App\Repositories\TransactionRepository;
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
            "transactions" => TransactionRepository::with("product")
                ->orderColumn("transaction_date", "DESC")
                ->getAllDataPaginated(["type" => TransactionType::SALE->name])
        ];
    }
}
