<?php

namespace App\Providers;

use App\Modules\Empresa\Providers\Implementations\SearchEmpresasProvider;
use App\Modules\Empresa\Providers\Models\ISearchEmpresasProvider;
use App\Modules\Empresa\Repositories\Implementations\EmpresaRepository;
use App\Modules\Empresa\Repositories\Models\IEmpresaRepository;
use App\Modules\Empresa\Services\CreateEmpresaService;
use App\Modules\Empresa\Services\ListAllEmpresasService;
use App\Modules\Empresa\Services\SearchAllEmpresasByAllTimeService;
use App\Modules\Empresa\Services\UpdateEmpresasContactService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IEmpresaRepository::class, EmpresaRepository::class);
        $this->app->singleton(CreateEmpresaService::class, CreateEmpresaService::class);
        $this->app->singleton(ListAllEmpresasService::class, ListAllEmpresasService::class);
        $this->app->singleton(ISearchEmpresasProvider::class, SearchEmpresasProvider::class);
        $this->app->singleton(UpdateEmpresasContactService::class, UpdateEmpresasContactService::class);
        $this->app->singleton(SearchAllEmpresasByAllTimeService::class, SearchAllEmpresasByAllTimeService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
