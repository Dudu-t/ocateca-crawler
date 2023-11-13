<?php

namespace App\Http\Controllers;

use App\Modules\Empresa\Services\SearchAllEmpresasByAllTimeService;
use App\Modules\Empresa\Services\SearchEmpresasService;
use Illuminate\Http\Request;

class SearchEmpresasController extends Controller
{
    private SearchAllEmpresasByAllTimeService $searchAllEmpresasByAllTimeService;
    public function __construct(SearchAllEmpresasByAllTimeService $searchAllEmpresasByAllTimeService)
    {
        $this->searchAllEmpresasByAllTimeService = $searchAllEmpresasByAllTimeService;
    }

    public function handle(Request $request){
        $this->searchAllEmpresasByAllTimeService->execute();
    }
}
