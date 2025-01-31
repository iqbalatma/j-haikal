<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restocks\StoreRestockReqest;
use App\Http\Requests\Sales\StoreSalesRequest;
use App\Services\RestockService;
use App\Services\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestockController extends Controller
{
    /**
     * @param RestockService $service
     * @return Response
     */
    public function index(RestockService $service): Response
    {
        viewShare($service->getAllDataPaginated());
        return response()->view("kelola.restocks.index");
    }

    /**
     * @param RestockService $service
     * @return Response
     */
    public function create(RestockService $service): Response
    {
        viewShare($service->getCreateData());
        return response()->view("kelola.restocks.create");
    }

    /**
     * @param SaleService $service
     * @param StoreRestockReqest $request
     * @return RedirectResponse
     */
    public function store(SaleService $service, StoreRestockReqest $request): RedirectResponse
    {
        $response = $service->addNewData($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route('restocks.index')->with("success", "Berhasil menambahkan data stok");
    }
}
