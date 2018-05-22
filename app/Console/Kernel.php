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

        \Muserpol\Console\Commands\FrDisponibilidadAportes::class,

        \Muserpol\Console\Commands\FusionAffiliate::class,
        \Muserpol\Console\Commands\ImportComplement2015::class,
        \Muserpol\Console\Commands\ImportComplement2016Primer::class,
        \Muserpol\Console\Commands\ImportFileMakerContribution::class,
        \Muserpol\Console\Commands\FusionOnlyAffiliate::class,
        \Muserpol\Console\Commands\ImportSismuNormal::class,
        \Muserpol\Console\Commands\ImportSismuReintegro::class,
        \Muserpol\Console\Commands\ImportRezagados::class,
        \Muserpol\Console\Commands\ImportBaseWageSismuNormal::class,
        \Muserpol\Console\Commands\ImportDaf::class,
        \Muserpol\Console\Commands\ImportBirthDate::class,
        \Muserpol\Console\Commands\ImportDates99dmy::class,
        \Muserpol\Console\Commands\ImportDates99ymd::class,
        \Muserpol\Console\Commands\ExportDateEntry::class,
        \Muserpol\Console\Commands\ExportRentDiffAPS::class,
        \Muserpol\Console\Commands\ExportRentDiffSenasir::class,
        \Muserpol\Console\Commands\CityBirthEcoComApplicants::class,
        \Muserpol\Console\Commands\PaidChangeAffiliateFondo::class,
        \Muserpol\Console\Commands\PaidChangeAffiliateAux::class,
        \Muserpol\Console\Commands\PaidChangeAffiliateCuo::class,
        \Muserpol\Console\Commands\ImportPayroll2017::class,
        \Muserpol\Console\Commands\CompareDataSenasir::class,
        \Muserpol\Console\Commands\CompareDataAPS::class,
        \Muserpol\Console\Commands\SetTotalRentAps::class,
        \Muserpol\Console\Commands\ImportTotalDuesRF::class,
        \Muserpol\Console\Commands\ImportSenasirsir::class,
        \Muserpol\Console\Commands\ImportClassRentSenasir::class,
        \Muserpol\Console\Commands\CopyAverage::class,
        \Muserpol\Console\Commands\DeleteObservationLoan::class,
        \Muserpol\Console\Commands\Concurrencia::class,
        \Muserpol\Console\Commands\UpdateComplementaryFactor::class,
        \Muserpol\Console\Commands\ImportBank::class,
        \Muserpol\Console\Commands\CheckRequirement::class,
        \Muserpol\Console\Commands\ImportacionMatriculas::class,
        \Muserpol\Console\Commands\ImportConciliacion::class,
        \Muserpol\Console\Commands\ImportPayroll2018::class,
        \Muserpol\Console\Commands\ImportReimbursement2018::class,
        \Muserpol\Console\Commands\SequenceNumber::class,
        \Muserpol\Console\Commands\CompleteListApplicants::class,
        \Muserpol\Console\Commands\UpdateAffilateState::class,
        \Muserpol\Console\Commands\RentasApsSegundoSemestre::class,
        \Muserpol\Console\Commands\AffiliateWithIdReport::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('create:ipcrate')->monthly();
        $schedule->command('create:contributionrate')->monthly();
    }
}
