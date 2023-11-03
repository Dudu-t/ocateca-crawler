<?php

namespace App\Console\Commands;

use App\Modules\Empresa\Services\UpdateEmpresasContactService;
use Illuminate\Console\Command;

class UpdateEmpresasContactCommand extends Command
{
    private UpdateEmpresasContactService $updateEmpresasContactService;
    public function __construct(UpdateEmpresasContactService $updateEmpresasContactService)
    {
        $this->updateEmpresasContactService = $updateEmpresasContactService;

        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza email e telefone das empresas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('INICIADA: Atualização dos contatos das empresas');
        $this->updateEmpresasContactService->execute();
        $this->info('FINALIZADA: Atualização dos contatos das empresas');
    }
}
