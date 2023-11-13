<?php

namespace App\Modules\Empresa\Services;

use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;

class SearchAllEmpresasByAllTimeService
{
    private SearchEmpresasService $searchEmpresasService;

    public function __construct(SearchEmpresasService $searchEmpresasService){
        $this->searchEmpresasService = $searchEmpresasService;
    }

    public function execute(){
        $caminhoArquivo = storage_path('app/crawler_history.json');

        $historyContent = File::exists($caminhoArquivo) ? File::get($caminhoArquivo) : null;
        $loadedHistory = json_decode($historyContent, true) ?? null;

        $initialDateString = $loadedHistory['inicio'] ?? '1945-01-01';
        $finalDateString = $loadedHistory['fim'] ?? '1945-01-08';

        $initialDate = new \DateTime($initialDateString);
        $finalDate = new \DateTime($finalDateString);

        $addInterval = \DateInterval::createFromDateString('7 day');

        $now = new \DateTime();
        $totalEmpresasEncontradas = 0;

        while ($finalDate < $now){
            $output = new ConsoleOutput();

            $output->writeln('BUSCANDO EMPRESA ABERTA ENTRE: '. $initialDate->format('d/m/Y').' - '.$finalDate->format('d/m/Y'));

            $totalEmpresasEncontradas +=  $this->searchEmpresasService->execute($initialDate, $finalDate);
            $output->writeln('TOTAL EMPRESAS INSERIDAS/ATUALIZADAS: '. $totalEmpresasEncontradas);
            $initialDate->add($addInterval);
            $finalDate->add($addInterval);

            $save = json_encode(['inicio'=>$initialDate->format('Y-m-d'), 'fim'=>$finalDate->format('Y-m-d')]);

            File::put($caminhoArquivo, $save);

            sleep(0.1);
        }

    }

}
