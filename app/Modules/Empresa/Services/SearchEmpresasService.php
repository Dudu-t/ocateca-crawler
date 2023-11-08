<?php

namespace App\Modules\Empresa\Services;

use App\Modules\Empresa\Providers\Models\ISearchEmpresasProvider;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

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
        $totalEmpresas = $maxPages*20;

        set_time_limit(60*60*48);

        $output = new ConsoleOutput();
        $count = 0;

        $secondsForEachRequest = 1.5;

        $expectedTime =  $secondsForEachRequest * $maxPages;

        $expectedTimeString = gmdate('H:i:s', $expectedTime);

        for ($page = 1; $page < $maxPages; $page++){
           $empresas = $this->searchEmpresasProvider->getEmpresasByPage($page);
            $remainingTime = ($maxPages - $page)*$secondsForEachRequest;
            $remainingTimeString = gmdate('H:i:s', $remainingTime);

           foreach ($empresas as $empresa){
               echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
               $count++;
               $output->writeln("========== INFORMAÇÕES GERAIS =========\nBUSCAR EMPRESAS \nTOTAL DE EMPRESAS: $totalEmpresas\nTEMPO TOTAL ESTIMADO: $expectedTimeString\n\n=============== PROGRESSO ===========", 4);
               $output->writeln("BUSCANDO EMPRESA  $count/$totalEmpresas");
               $output->writeln("PORCENTAGEM CONCLUIDA: ". (int)($count/$totalEmpresas). '%');
               $output->writeln("TEMPO RESTANTE: $remainingTimeString");
               if ($this->empresaRepository->getEmpresaByCpnj($empresa->cnpj)) continue;
               $this->createEmpresaService->execute($empresa);

           }
            sleep($secondsForEachRequest);
        }
        Log::info('FINISHED SEARCHING EMPRESAS - TOTAL PAGES: '. $maxPages);
    }
}
