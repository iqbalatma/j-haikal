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
