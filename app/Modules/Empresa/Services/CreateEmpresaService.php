<?php

namespace App\Modules\Empresa\Services;

use App\Models\Empresa;
use App\Modules\Empresa\DTOS\EmpresaDTO;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;

class CreateEmpresaService
{

    private IEmpresaRepository $empresaRepository;

    public function __construct(IEmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    public function execute(EmpresaDTO $empresa): EmpresaDTO
    {
        return  $this->empresaRepository->create($empresa);
    }

}
