<?php

namespace App\Http\Controllers;

use App\Http\Requests\Restocks\StoreRestockByForecastingRequest;
use App\Http\Requests\Restocks\StoreRestockByForecastingSupplierRequest;
use App\Http\Requests\Restocks\StoreRestockReqest;
use App\Models\Facture;
use App\Services\RestockService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
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
    public function restockForecasting(RestockService $service): Response
    {
        viewShare($service->restockForForecasting());
        return response()->view("kelola.restocks.restock-plan");
    }


    /**
     * @param RestockService $service
     * @return Response
     */
    public function restockAddSupplier(RestockService $service): Response
    {
        viewShare($service->restockForForecastingSupplier());
        return response()->view("kelola.restocks.restock-supplier");
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
     * @param RestockService $service
     * @param StoreRestockByForecastingSupplierRequest $request
     * @return RedirectResponse
     */
    public function storeByForecastingSupplier(RestockService $service, StoreRestockByForecastingSupplierRequest $request): RedirectResponse
    {
        $response = $service->restockByForecastingSupplier($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();
        return redirect()->route('restocks.restock.add.supplier', ["period" => request()->input("period")])->with("success", "Berhasil menambahkan supplier");
    }


    /**
     * @param RestockService $service
     * @param StoreRestockByForecastingRequest $request
     * @return RedirectResponse
     */
    public function storeByForecasting(RestockService $service, StoreRestockByForecastingRequest $request): RedirectResponse
    {
        $response = $service->restockByForecasting($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();
        return redirect()->route('restocks.restock.by.forecasting', ["period" => request()->input("period")])->with("success", "Berhasil menambahkan data stok");
    }

    /**
     * @param RestockService $service
     * @param StoreRestockReqest $request
     * @return RedirectResponse
     */
    public function store(RestockService $service, StoreRestockReqest $request): RedirectResponse
    {
        $response = $service->addNewData($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route('restocks.index')->with("success", "Berhasil menambahkan data stok");
    }
}
