<?php

namespace App\Modules\Empresa\Providers\Models;

use App\Modules\Empresa\DTOS\EmpresaDTO;

interface ISearchEmpresasProvider
{
    /**
     * @param int $page
     * @param \DateTime $inicioDataAbertura
     * @param \DateTime $fimDataAbertura
     * @return EmpresaDTO[]
     */
    public function getEmpresasByPage(int $page, \DateTime $inicioDataAbertura, \DateTime $fimDataAbertura): array;

    /**
     * @param \DateTime $inicioDataAbertura
     * @param \DateTime $fimDataAbertura
     * @return int
     */
    public function getCountTotalPages(\DateTime $inicioDataAbertura, \DateTime $fimDataAbertura): int;

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
