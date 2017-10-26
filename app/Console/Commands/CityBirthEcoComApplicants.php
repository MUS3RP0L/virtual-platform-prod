<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Muserpol\EconomicComplementApplicant;
class CityBirthEcoComApplicants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:city_birth_applicants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        global $Progress, $aficount,$apps;
             $password = $this->ask('Enter the password');
             if ($password == ACCESS) {
                     $time_start = microtime(true);
                     $this->info("Working...\n");
                     $Progress = $this->output->createProgressBar();
                     $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                     $eco_com_applicants=DB::table('economic_complements')
                     ->leftJoin('eco_com_applicants', 'economic_complements.id', '=', 'eco_com_applicants.economic_complement_id')
                     ->leftJoin('eco_com_modalities', 'economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                     ->leftJoin('eco_com_types', 'eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                     ->where('economic_complements.eco_com_procedure_id', '=', 2)
                     ->where('eco_com_types.id', '=', 1)
                     ->whereNull('eco_com_applicants.city_birth_id')
                     ->select('eco_com_applicants.id')
                     ->get();
                     foreach ($eco_com_applicants as $key => $app) {
                        $Progress->advance();
                        $apps++;
                        $eco_app=EconomicComplementApplicant::where('id','=', $app->id)->first();
                        $aff=$eco_app->economic_complement->affiliate;
                        if (!$eco_app->city_birth_id && $aff->city_birth_id) {
                            $eco_app->city_birth_id = $aff->city_birth_id;
                            $eco_app->save();
                            $aficount++;
                        }
                     }
                     $time_end = microtime(true);
                     $execution_time = ($time_end - $time_start)/60;
                     $Progress->finish();
                     $this->info("\n\n\n
                         \tTotal afiliados actualizados:  $aficount/$apps \n
                     Execution time $execution_time [minutes].\n");
            }else {
                $this->error('Incorrect password!');
                exit();
            }
         
    }
}
