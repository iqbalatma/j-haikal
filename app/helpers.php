<?php

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
