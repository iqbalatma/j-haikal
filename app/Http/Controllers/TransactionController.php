<?php

namespace App\Http\Controllers;

use App\Services\SaleService;
use App\Services\TransactionService;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * @param TransactionService $service
     * @return Response
     */
    public function index(TransactionService $service): Response
    {
        viewShare($service->getAllDataPaginated());
        return response()->view("kelola.transactions.index");
    }
}
