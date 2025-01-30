<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaction;
use App\Services\ForecastingService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ForecastingController extends Controller
{
    /**
     * @param ForecastingService $service
     * @return Response
     */
    public function index(ForecastingService $service): Response
    {
        $response = $service->getAllDataPaginated();
        return response()->view('kelola.forecasting.index', $response);
    }
}
