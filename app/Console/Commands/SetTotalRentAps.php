<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementProcedure;

class SetTotalRentAps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:total_rent_aps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set total rent from fractions Aps';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            $year = $this->ask('Enter the year');
            $semester = $this->anticipate('Enter the semester: ', ['Primer', 'Segundo']);
            if($this->confirm('Are you sure? [y|N]') && $year && $semester)
                {   $time_start = microtime(true);
                    $this->info("Working...\n");
                    $Progress = $this->output->createProgressBar();
                    $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                    $Progress->advance();

                    $procedure=EconomicComplementProcedure::where('semester','like',$semester)->whereYear('year', '=', $year)->first();
                    if ($procedure) {
                        
                        $ecos = EconomicComplement::where('eco_com_procedure_id','=',$procedure->id)
                            ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                            ->leftJoin('pension_entities', 'affiliates.pension_entity_id', '=', 'pension_entities.id')
                            ->whereIn('pension_entities.id', [1,2,3,4])
                            ->select('economic_complements.id')
                        ->get()
                        ->pluck('id');
                        $ecos=EconomicComplement::whereIn('id',$ecos)->get();
                        foreach ($ecos as $key => $eco) {
                            if (! $eco->total_rent > 0) {
                                $total_fac=($eco->aps_total_cc ?? 0) + ($eco->aps_total_fsa ?? 0) + ($eco->aps_total_fs ?? 0); 
                                if ($total_fac >  0) {
                                    $eco->total_rent = $total_fac;
                                    $eco->save();
                                }
                            }
                            $Progress->advance();
                        }

                        $time_end = microtime(true);
                        $execution_time = ($time_end - $time_start)/60;
                        $Progress->finish();

                        $this->info("\n\nReport set total frac to total_rent:\n
                            Execution time $execution_time [minutes].\n");
                    }
                }
                else {
                    $this->error(' Enter year and semester!');
                }
            }
            else {
                $this->error('Incorrect password!');
                exit();
            }

    }
}
