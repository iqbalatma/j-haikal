<?php

namespace App\Services;
use App\Models\Forecasting;
use Iqbalatma\LaravelServiceRepo\BaseService;

class ForecastingService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }

    /**
     * @return array
     */
    public function getAllDataPaginated():array
    {
        $query = Forecasting::query()->orderBy("period", "DESC");
        if ($period = request()->input("period")){
            $query->where("period", $period);
        }

        if ($productCode = request()->input("kode_produk")){
            $query->whereHas("product", function ($query) use ($productCode) {
                $query->where("kode_produk", $productCode);
            });
        }
        return [
            "forecastings" => $query->paginate(25),
        ];
    }
}
