<?php

namespace App\Http\Controllers;

use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaleController extends Controller
{
    /**
     * @param SaleService $service
     * @return Response
     */
    public function index(SaleService $service): Response
    {
        viewShare($service->getAllDataPaginated());
        return response()->view("kelola.sales.index");
    }
}
