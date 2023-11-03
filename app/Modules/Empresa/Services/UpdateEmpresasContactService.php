<?php

namespace App\Modules\Empresa\Services;

use App\Modules\Empresa\Providers\Models\ISearchEmpresasProvider;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;
use Illuminate\Support\Facades\Log;

class UpdateEmpresasContactService
{

    private IEmpresaRepository $empresaRepository;
    private ISearchEmpresasProvider $searchEmpresasProvider;

    public function __construct(IEmpresaRepository $empresaRepository, ISearchEmpresasProvider $searchEmpresasProvider)
    {
        $this->empresaRepository = $empresaRepository;
        $this->searchEmpresasProvider = $searchEmpresasProvider;
    }

    public function execute()
    {
        $empresasWithoutContact = $this->empresaRepository->getEmpresasWithNullContact();

        set_time_limit(60*60*15);

        Log::info('UPDATING EMPRESAS - TOTAL EMPRESA: '. sizeof($empresasWithoutContact));

        foreach($empresasWithoutContact as $empresa)
        {
            $updatedEmpresa = $this->searchEmpresasProvider->getEmpresaEmailAndTelefoneByUrl($empresa);
            $this->empresaRepository->update($updatedEmpresa);
            sleep(1.5);
        }

        Log::info('FINISHED UPDATE EMPRESAS - TOTAL EMPRESA: '. sizeof($empresasWithoutContact));
    }
}
