<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use App\Services\FactureService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FactureController extends Controller
{
    /**
     * @param FactureService $service
     * @return Response
     */
    public function index(FactureService $service): Response
    {
        viewShare($service->getAllDataPaginated());
        return response()->view("kelola.factures.index");
    }

    public function download(string $id)
    {
        $facture = Facture::query()->where("id", $id)->first();
        if (!$facture) {
            abort(404);
        }
        $filename = $facture->filename;
        $file = Storage::disk("factures")->get("app/factures/".$filename);

        if (!$file) {
            abort(404);
        }

        $headers = [
            'Content-Type' => "pdf",
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$filename}",
            'filename'=> $filename
        ];
        return response($file, 200, $headers);
    }
}
