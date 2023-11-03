<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Modules\Empresa\DTOS\EmpresaDTO;
use App\Modules\Empresa\Services\CreateEmpresaService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class CreateEmpresaController extends Controller
{
    private CreateEmpresaService $createEmpresaService;
    public function __construct(CreateEmpresaService $createEmpresaService)
    {
        $this->createEmpresaService = $createEmpresaService;
    }

    public function handle(Request $request){
        $data = $request->all();
        $create_empresa = new EmpresaDTO();
        $create_empresa->fromArray($data);

        $empresa = $this->createEmpresaService->execute($create_empresa);
        return response()->json($empresa);
    }
}
