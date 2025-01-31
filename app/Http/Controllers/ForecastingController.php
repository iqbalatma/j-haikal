<?php

namespace App\Http\Controllers;

use App\Http\Requests\Forecastings\StoreForecastingRequest;
use App\Services\ForecastingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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

    /**
     * @param ForecastingService $service
     * @param StoreForecastingRequest $request
     * @return RedirectResponse
     */
    public function store(ForecastingService $service, StoreForecastingRequest $request): RedirectResponse
    {
        $response = $service->addNewData($request->validated());
        if ($this->isError($response)) return $this->getErrorResponse();

        return redirect()->route('forecasting.index')->with("success", "Berhasil melakukan peramalam data");
    }
}
