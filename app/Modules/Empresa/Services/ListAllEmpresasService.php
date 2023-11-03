<?php

namespace App\Modules\Empresa\Services;

use App\Modules\Empresa\DTOS\EmpresaDTO;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;

class ListAllEmpresasService
{
    private IEmpresaRepository $empresaRepository;

    public function __construct(IEmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * @return EmpresaDTO[]
    */

    public function execute(): array{
        return $this->empresaRepository->listAll();
    }
}
