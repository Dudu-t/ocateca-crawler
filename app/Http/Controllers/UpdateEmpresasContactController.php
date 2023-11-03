<?php

namespace App\Http\Controllers;

use App\Modules\Empresa\Services\UpdateEmpresasContactService;
use Illuminate\Http\Request;

class UpdateEmpresasContactController extends Controller
{
    private UpdateEmpresasContactService $updateEmpresasContactService;
    public function __construct(UpdateEmpresasContactService $updateEmpresasContactService)
    {
        $this->updateEmpresasContactService = $updateEmpresasContactService;
    }

    public function handle(Request $request)
    {
        $this->updateEmpresasContactService->execute();
    }
}
