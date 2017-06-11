<?php

namespace Muserpol\Providers;

use Illuminate\Support\ServiceProvider;
use Muserpol\EconomicComplement;
use Muserpol\WorkflowRecord;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        EconomicComplement::created(function ($economic_complement)
        {
            WorkflowRecord::creatingEconomicComplement($economic_complement);
        });
        EconomicComplement::updating(function ($economic_complement)
        {
            WorkflowRecord::updatedEconomicComplement($economic_complement);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
