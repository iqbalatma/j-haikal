<?php

use App\Services\ForecastingService;
use Illuminate\Support\Collection;

if (!function_exists("formatToRupiah")) {
    /**
     * Description : use to format to rupiah
     *
     * @param float|null $number value for format
     * @param string $fallbackValue
     * @return string
     */
    function formatToRupiah(float|null $number, string $fallbackValue = "-"): string
    {
        if (is_null($number)) {
            return $fallbackValue;
        }
        return "Rp " . number_format($number, 2, ",", ".");
    }
}


if (!function_exists("getMonths")) {
    /**
     * Description : use to format to rupiah
     *
     * @return array
     */
    function getMonths(): array
    {
        return [
            1 => "Januari",
            2 => "Februari",
            3 => "Maret",
            4 => "April",
            5 => "Mei",
            6 => "Juni",
            7 => "Juli",
            8 => "Agustus",
            9 => "September",
            10 => "Oktober",
            11 => "November",
            12 => "Desember",
        ];
    }
}


if (!function_exists("getMAPE")) {
    /**
     * @param array $data
     * @return float|null
     */
    function getMAPE(array $data): float|null
    {
        if (count($data) === 0) {
            return null;
        }

        $collection = collect($data);

        $total = 0;

        foreach ($collection as $item) {
            $total += abs(($item["actual"] - $item["prediction"]) / $item["actual"]) * 100;
        }

        return $total / count($collection);
    }
}

if (!function_exists("getMAD")) {
    function getMAD(array $data): float|null
    {
        if (count($data) === 0) {
            return null;
        }

        $collection = collect($data);

        $total = 0;

        foreach ($collection as $item) {
            $total += abs($item["actual"] - $item["prediction"]);
        }

        return $total / count($collection);
    }
}


if (!function_exists("getMSE")) {
    function getMSE(array $data): float|null
    {
        if (count($data) === 0) {
            return null;
        }
        $collection = collect($data);

        $total = 0;
        foreach ($collection as $item) {
            $total += abs($item["actual"] - $item["prediction"]) ** 2;
        }

        return $total / count($collection);
    }
}

if (!function_exists("getSafetyStock")) {
    function getSafetyStock(array|Collection $data): int|null
    {
        if (count($data) === 0) {
            return null;
        }
        $collection = collect($data);


        $max = $collection->max("quantity") / $collection->count();
        $avg = $collection->avg("quantity") / $collection->count();

        $safetyStock = ($max - $avg) * ForecastingService::LEAD_TIME;

        return round($safetyStock, 0);
    }
}



if (!function_exists('getTrimmedOrNull')) {

    /**
     * @param string $value
     * @return string|null
     */
    function getTrimmedOrNull(string $value): string|null
    {
        return trim($value) === "" ? null : trim($value);
    }
}
