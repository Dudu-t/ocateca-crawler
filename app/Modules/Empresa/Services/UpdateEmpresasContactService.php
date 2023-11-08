<?php

namespace App\Modules\Empresa\Services;

use App\Modules\Empresa\Providers\Models\ISearchEmpresasProvider;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\ConsoleOutput;

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

        set_time_limit(60*60*48);



        $output = new ConsoleOutput();
        $count = 0;
        $totalEmpresas = sizeof($empresasWithoutContact);
        $secondsForEachRequest = 1.5;

        $expectedTimeString = gmdate('H:i:s', $secondsForEachRequest*$totalEmpresas);

        foreach($empresasWithoutContact as $empresa)
        {
            echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
            $count++;
            $remainingTime = ($totalEmpresas - $count)*$secondsForEachRequest;
            $remainingTimeString = gmdate('H:i:s', $remainingTime);
            $output->writeln("========== INFORMAÇÕES GERAIS =========\nUPDATING EMPRESAS \nTOTAL DE EMPRESAS: $totalEmpresas\nTEMPO TOTAL ESTIMADO: $expectedTimeString\n\n=============== PROGRESSO ===========", 4);
            $output->writeln("ATUALIZANDO CONTATO DA EMPRESA  $count/$totalEmpresas");
            $output->writeln("PORCENTAGEM CONCLUIDA: ". (int)($count/$totalEmpresas). '%');
            $output->writeln("TEMPO RESTANTE: $remainingTimeString");
            $updatedEmpresa = $this->searchEmpresasProvider->getEmpresaEmailAndTelefoneByUrl($empresa);
            $this->empresaRepository->update($updatedEmpresa);
        }

        $output->writeln('FINISHED UPDATE EMPRESAS - TOTAL EMPRESA: '. $totalEmpresas);
    }
}
