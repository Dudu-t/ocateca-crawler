<?php

namespace App\Http\Controllers;

use App\Modules\Empresa\Services\SearchEmpresasService;
use Illuminate\Http\Request;

class SearchEmpresasController extends Controller
{
    private SearchEmpresasService $searchEmpresasService;
    public function __construct(SearchEmpresasService $searchEmpresasService)
    {
        $this->searchEmpresasService = $searchEmpresasService;
    }

    public function handle(Request $request){
        $this->searchEmpresasService->execute();
    }
}
