<?php

namespace App\Modules\Empresa\Services;

use App\Modules\Empresa\Providers\Models\ISearchEmpresasProvider;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;
use Illuminate\Support\Facades\Log;

class SearchEmpresasService
{
    private ISearchEmpresasProvider $searchEmpresasProvider;
    private CreateEmpresaService $createEmpresaService;
    private IEmpresaRepository $empresaRepository;

    public function __construct(ISearchEmpresasProvider $searchEmpresasProvider, CreateEmpresaService $createEmpresaService, IEmpresaRepository $empresaRepository){
        $this->searchEmpresasProvider = $searchEmpresasProvider;
        $this->createEmpresaService = $createEmpresaService;
        $this->empresaRepository = $empresaRepository;
    }

    public function execute(){
        $maxPages = $this->searchEmpresasProvider->getCountTotalPages();

        set_time_limit(60*60*15);
        Log::info('SEARCHING EMPRESAS - TOTAL PAGES: '. $maxPages);
        for ($page = 1; $page < $maxPages; $page++){
           $empresas = $this->searchEmpresasProvider->getEmpresasByPage($page);
           foreach ($empresas as $empresa){

               if ($this->empresaRepository->getEmpresaByCpnj($empresa->cnpj)) continue;
               $this->createEmpresaService->execute($empresa);
           }
            sleep(1.5);
        }
        Log::info('FINISHED SEARCHING EMPRESAS - TOTAL PAGES: '. $maxPages);
    }
}
