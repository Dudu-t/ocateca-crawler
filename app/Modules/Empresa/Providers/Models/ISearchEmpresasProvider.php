<?php

namespace App\Modules\Empresa\Providers\Models;

use App\Modules\Empresa\DTOS\EmpresaDTO;

interface ISearchEmpresasProvider
{
    /**
     * @param int $page
     * @return EmpresaDTO[]
     */
    public function getEmpresasByPage(int $page): array;

    /**
     * @return int
    */
    public function getCountTotalPages(): int;

    /**
     * @param string $razaoSocial
     * @param string $cnpj
     * @return string
     */
    public function getUrlSearchByRazaoSocialAndCnpj(string $razaoSocial, string $cnpj): string;

    /**
     * @param string $url
     * @return EmpresaDTO
     */
    public function getEmpresaEmailAndTelefoneByUrl(EmpresaDTO $empresa): EmpresaDTO;
}
