<?php

namespace App\Modules\Empresa\Repositories\Implementations;

use App\Models\Empresa;
use App\Modules\Empresa\DTOS\EmpresaDTO;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;
use Illuminate\Support\Str;

class EmpresaRepository implements IEmpresaRepository
{
    /**
     * @inheritDoc
     */
    public function create(EmpresaDTO $empresa): EmpresaDTO
    {

        $createEmpresa = Empresa::create((array)$empresa);

        $createdEmpresa = new EmpresaDTO();
        $createdEmpresa->fromObject($createEmpresa);

        return $createdEmpresa;
    }

    /**
     * @inheritDoc
     */
    public function listAll(): array
    {
        $empresas = Empresa::all();

        /** @var EmpresaDTO[] $listEmpresas */

        $listEmpresas = [];

        foreach ($empresas as $empresa){
            $emp = new EmpresaDTO();
            $emp->fromArray($empresa->toArray());
            $listEmpresas[] = $emp;
        }

        return $listEmpresas;
    }

    /**
     * @inheritDoc
     */
    public function getEmpresaByCpnj(string $cnpj): ?EmpresaDTO
    {
        $searchEmpresa = Empresa::where('cnpj', $cnpj)->first();
        if (!$searchEmpresa) return null;

        $empresa = new EmpresaDTO();
        $empresa->fromObject($searchEmpresa);

        return $empresa;
    }

    /**
     * @inheritDoc
     */
    public function getEmpresasWithNullContact(): array
    {
        $searchEmpresas = Empresa::where('telefone', null)->orWhere('email', null)->orWhere('owner_name', null)->get();

        /** @var EmpresaDTO[] $listEmpresas */

        $empresas = [];

        foreach ($searchEmpresas as $empresa){
            $emp = new EmpresaDTO();
            $emp->fromArray($empresa->toArray());
            $empresas[] = $emp;
        }

        return $empresas;
    }

    /**
     * @inheritDoc
     */
    public function update(EmpresaDTO $empresa): EmpresaDTO
    {
        $emp = (array)$empresa;
        $updateEmpresa = Empresa::where('id', $empresa->id)->update($emp);

        return $empresa;
    }
}
