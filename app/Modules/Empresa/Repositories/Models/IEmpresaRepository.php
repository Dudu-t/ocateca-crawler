<?php

namespace App\Modules\Empresa\Repositories\Models;

use App\Modules\Empresa\DTOS\EmpresaDTO;


interface IEmpresaRepository
{
    /**
     * @param EmpresaDTO $empresa
     * @return EmpresaDTO
     */
    public function create(EmpresaDTO $empresa): EmpresaDTO;

    /**
     * @return EmpresaDTO[]
     */
    public function listAll(): array;

    /**
     * @param string $cnpj
     * @return EmpresaDTO|null
     */
    public function getEmpresaByCpnj(string $cnpj): ?EmpresaDTO;

    /**
     * @return EmpresaDTO[]
     */
    public function getEmpresasWithNullContact(): array;

    /**
     * @param EmpresaDTO $empresa
     * @return EmpresaDTO
     */
    public function update(EmpresaDTO $empresa): EmpresaDTO;

}
