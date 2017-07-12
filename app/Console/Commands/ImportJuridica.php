<?php
namespace Muserpol\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Muserpol\Degree;
use Muserpol\Affiliate;
use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplement;


use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

class ImportJuridica extends Command implements SelfHandling
{
    protected $signature = 'import:juridica';
    protected $description = 'Import observation of Legal';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) 
        {
                $year = $this->ask('Enter the year');
                $semester = $this->ask('Enter the semester');

                if($year > 0 and $semester != null)
                {   
                    $FolderName = $this->ask('Enter the name of the folder you want to import');

                    if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) 
                    {
                        $time_start = microtime(true);
                        $this->info("Working...\n");
                        $Progress = $this->output->createProgressBar();
                        $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                   

                        Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) 
                        {
                            $rows->each(function($result) 
                            {
                                    global $Progress;
                                    ini_set('memory_limit', '-1');
                                    ini_set('max_execution_time', '-1');
                                    ini_set('max_input_time', '-1');
                                    set_time_limit('-1');
                                    $Progress->advance();

                                    $ecom = DB::table('economic_complements')
                                          ->select(DB::raw('affiliates.id as afi_id,affiliates.identity_card as ci_afi,economic_complements.*, eco_com_types.id as type'))     
                                          ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')                                 
                                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                          ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                          ->whereRaw("LTRIM(affiliates.identity_card,'0') ='".$result->ci."'")                                          
                                          ->whereYear('economic_complements.year', '=', $year)
                                          ->where('economic_complements.semester', '=', $semester)->first();
                                    if($ecom)
                                    {   
                                        $obs = AffiliateObservation::where('affiliate_id','=', $ecom->ci_afi)->where('observation_type_id','=', 3)->first();
                                        if(!$obs)
                                        {
                                            $obs = new AffiliateObservation;
                                            $obs->user_id = 19;
                                            $obs->affiliate_id = $ecom->afi_id;
                                            $obs->observation_type_id = 3;
                                            $obs->date = Carbon::now();
                                            $obs->message = $result->observacion;
                                            $obs->save();                                             
                                        }

                                    }

                            });

                        });

                        $time_end = microtime(true);
                        $execution_time = ($time_end - $time_start)/60;
                        $Progress->finish();
                        $this->info("\n\nReport Calculate average:\n
                        Execution time $execution_time [minutes].\n");
                    }
                }
                else 
                {
                    $this->error(' Enter year and semester!');
                }
       }
       else 
       {
           $this->error('Incorrect password!');
           exit();
       }

    }
}
