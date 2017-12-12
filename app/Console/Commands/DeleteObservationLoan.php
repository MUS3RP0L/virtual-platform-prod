<?php
namespace Muserpol\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Muserpol\Degree;
use Muserpol\Affiliate;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementRent;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;
use Log;

class DeleteObservationLoan extends Command implements SelfHandling
{
    protected $signature = 'clean:observation';
    protected $description = 'Delete observation Loan';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   global $Progress,$rev,$nrev, $exrev,$exnrev;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');

        $password = $this->ask('Enter the password');
        if ($password == ACCESS) 
        {
            $time_start = microtime(true);
            $this->info("Working...\n");
            $Progress = $this->output->createProgressBar();
            $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
            

            $rev=0;
            $nrev=0;
            $ecom1 = EconomicComplement::where('eco_com_procedure_id','=',2)
                                        ->whereIn('eco_com_state_id',[1,18,17])->get();
            foreach ($ecom1 as $dato) 
            {   $Progress->advance();
                 $actual = EconomicComplement::where('eco_com_procedure_id','=',6)
                                        //->where('wf_current_state_id','=',3)
                                        ->where('economic_complements.reception_type','=','Habitual')
                                        //->where('state','=','Received')
                                        ->where('affiliate_id','=',$dato->affiliate_id)->first();
                if($actual)
                {   $actual->user_id=9;
                    $actual->wf_current_state_id = '3';
                    $actual->state='Edited';
                    $date = Carbon::Now();
                    $actual->review_date =$date; 
                    $actual->save();
                    $rev++;
                }
                else
                {
                    $nrev++;
                }
            }


            $FolderName = $this->ask('Enter the name of the folder you want to import');
            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) 
            {               
                
                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) 
                {
                    $rows->each(function($result) 
                    {
                        global $Progress,$exrev,$exnrev;
                        //$this->info($result->ci);                     
                        $ci = $result->ci;                    
                        if($result->tipo_renta == "VEJEZ")
                        {   //dd($result->tipo_renta."hola");
                            $app=EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                         ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                                         ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                                         ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                                         ->where('eco_com_types.id','=',1)
                                                         //->where('eco_com_applicants.identity_card','=',rtrim($ci))
                                                         ->whereRaw("ltrim(trim(eco_com_applicants.identity_card),'0') ='".ltrim(trim($ci),'0')."'")
                                                         ->where('economic_complements.eco_com_procedure_id','=',6)
                                                         ->where('economic_complements.reception_type','=','Habitual')
                                                         //->where('economic_complements.wf_current_state_id','=',3)
                                                         //->where('economic_complements.state','=','Received')
                                                         ->select('economic_complements.id','economic_complements.affiliate_id')->first();
                            
                             if($app)
                             {   //$this->info($ci);
                                 $ecom = EconomicComplement::where('id','=',$app->id)->first();
                                 $ecom->user_id=9; 
                                 $ecom->wf_current_state_id = 3;                                                    
                                 $ecom->state = 'Edited';
                                 $date = Carbon::Now();
                                 $ecom->review_date =$date; 
                                 $ecom->save();                              
                                 $exrev++;
                             }
                             else
                             {                                  
                                 
                                
                                //$this.info((string)$ci."-");
                                $exnrev++;
                             }
                         
                        }
                        elseif($result->tipo_renta =='VIUDEDAD')
                        {   
                            $app=EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                        ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                                        ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                                        ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                                        ->where('eco_com_types.id','=',2)
                                                        //->where('eco_com_applicants.identity_card','=',rtrim($ci))
                                                        ->whereRaw("ltrim(trim(eco_com_applicants.identity_card),'0') ='".ltrim(trim($ci),'0')."'")
                                                        ->where('economic_complements.eco_com_procedure_id','=',6)
                                                        ->where('economic_complements.reception_type','=','Habitual')
                                                        //->where('economic_complements.wf_current_state_id','=',3)
                                                        //->where('economic_complements.state','=','Received')
                                                        ->select('economic_complements.id','economic_complements.affiliate_id')
                                                        ->first();
                                  
                             if($app)
                             {  $ecom = EconomicComplement::where('id','=',$app->id)->first();
                                $ecom->user_id=9; 
                                $ecom->wf_current_state_id = 3;
                                $ecom->state='Edited';
                                $date = Carbon::Now();
                                $ecom->review_date =$date; 
                                $ecom->save();
                                $exrev++;
                             }
                             else
                             {                                   
                                
                                //$this.info((string)$ci."-");
                                $exnrev++;
                             }
                        }

                       

                    });

                });
            }



                 
                    

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;
            $Progress->finish();
            $this->info("\n\nEncontrados: $rev\n
                    NoEncontados: $nrev\n
                    Excel encontrados: $exrev\n
                    Excel no encontrados: $exnrev\n
                    Execution time $execution_time [minutes].\n");
             
       }
       else 
       {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
