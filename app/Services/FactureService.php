<?php

namespace App\Services;

use App\Models\Facture;
use App\Models\Suplier;
use Iqbalatma\LaravelServiceRepo\BaseService;

class FactureService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }

    public function getAllDataPaginated(): array
    {
        $factures = Facture::query();
        if ($period = request()->input("period")){
            $factures->where("period", $period);
        }

        if ($supplierId = request()->input("supplier_id")){
            $factures->where("supplier_id", $supplierId);
        }

        return [
            "suppliers" => Suplier::query()->get(),
            "factures" => $factures->paginate()
        ];
    }
}
