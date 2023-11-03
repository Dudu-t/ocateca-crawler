<?php

namespace App\Console\Commands;

use App\Modules\Empresa\Services\SearchEmpresasService;
use Illuminate\Console\Command;

class SearchEmpresasCommand extends Command
{
    private SearchEmpresasService $searchEmpresasService;
    public function __construct(SearchEmpresasService $searchEmpresasService)
    {
        $this->searchEmpresasService = $searchEmpresasService;

        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicia crawler de busca por empresas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('INICIADA: Busca por empresas');
        $this->searchEmpresasService->execute();
        $this->info('FINALIZADA: Busca por empresas ');
    }
}
