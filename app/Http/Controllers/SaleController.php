<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sales\StoreSalesRequest;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
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

    /**
     * @param SaleService $service
     * @return Response
     */
    public function create(SaleService $service): Response
    {
        viewShare($service->getCreateData());
        return response()->view("kelola.sales.create");
    }

    /**
     * @param SaleService $service
     * @param StoreSalesRequest $request
     * @return RedirectResponse
     */
    public function store(SaleService $service, StoreSalesRequest $request): RedirectResponse
    {
        $response = $service->addNewData($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route('sales.index')->with("success", "Berhasil menambahkan data penjualan");
    }
}
