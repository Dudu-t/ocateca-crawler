<?php

namespace App\Http\Controllers;

use App\Modules\Empresa\Services\ListAllEmpresasService;
use Illuminate\Http\Request;

class ListAllEmpresasController extends Controller
{
    private ListAllEmpresasService $listAllEmpresasService;

    public function __construct(ListAllEmpresasService $listAllEmpresasService)
    {
        $this->listAllEmpresasService = $listAllEmpresasService;
    }

    public function handle(Request $request){
        $empresas = $this->listAllEmpresasService->execute();
        return response()->json($empresas);
    }
}
