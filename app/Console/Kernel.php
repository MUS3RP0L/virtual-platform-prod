<?php

namespace Muserpol\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

        \Muserpol\Console\Commands\ImportPayroll::class,
        \Muserpol\Console\Commands\ImportReimbursement::class,
        \Muserpol\Console\Commands\ImportBaseWage::class,
        \Muserpol\Console\Commands\ImportEcoCom::class,
        \Muserpol\Console\Commands\CreateIpcRate::class,
        \Muserpol\Console\Commands\CreateContributionRate::class,
        \Muserpol\Console\Commands\importfinal::class,
        \Muserpol\Console\Commands\CalculateAverage::class,
        \Muserpol\Console\Commands\ImportComplement::class,
        \Muserpol\Console\Commands\ImportRequirement::class,
        \Muserpol\Console\Commands\AutomaticCalculation::class,
        \Muserpol\Console\Commands\ImportJuridica::class,
        \Muserpol\Console\Commands\UpdateAffiliateRecords::class,
        \Muserpol\Console\Commands\ExportExcel::class,
        \Muserpol\Console\Commands\ImportRegional::class,
        \Muserpol\Console\Commands\UpdateCategory::class,
        \Muserpol\Console\Commands\ImportDisability::class,
        \Muserpol\Console\Commands\UpdateReceptionType::class,
        \Muserpol\Console\Commands\ImportacionesBases::class,
        \Muserpol\Console\Commands\Exportar_de_MDB::class,
        \Muserpol\Console\Commands\ImportAvailabilityDate::class,
        \Muserpol\Console\Commands\UpdateState::class,
        \Muserpol\Console\Commands\UpdateRequirementsDate::class,
        \Muserpol\Console\Commands\importObservations::class,
        \Muserpol\Console\Commands\Fusion::class,
        \Muserpol\Console\Commands\UpdateDegreeToEcoCom::class,
        \Muserpol\Console\Commands\SearchDegreeChange::class,
        \Muserpol\Console\Commands\ObservationsAmount::class,
        \Muserpol\Console\Commands\ObservationDegreeAndCategory::class,
        \Muserpol\Console\Commands\ObservationExcelCategoryDegree::class,
        \Muserpol\Console\Commands\FrDisponibilidad::class,
        \Muserpol\Console\Commands\FusionAffiliate::class,
        \Muserpol\Console\Commands\ImportComplement2015::class,
        \Muserpol\Console\Commands\ImportComplement2016Primer::class,

        
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('create:ipcrate')->monthly();
        $schedule->command('create:contributionrate')->monthly();
    }
}
