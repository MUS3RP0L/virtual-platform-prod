<?php

namespace Muserpol\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;

class ImportRequirement extends Command implements SelfHandling
{
    protected $signature = 'import:req';   
    protected $description = 'Command description';

    public function handle()
    {   global $Progress,$vej, $viu, $orf,$newafi,$oldafi,$totalafi;
        
        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();                
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {
                    $rows->each(function($result) {
                            global $Progress,$vej, $viu, $orf,$newafi,$oldafi,$totalafi;
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
                            $Progress->advance(); 

                            $app = EconomicComplementApplicant::where('identity_card','=', $result->ci)->first();
                            if($app) 
                            {
                                    $ecom = EconomicComplement::where('economic_complements.affiliate_id','=', $app->id)->whereYear('year','=', 2016)->where('semester','=', 'Segundo')->first();   

                                    if ($result->tiporenta == 'VEJEZ' or $result->tiporenta == 'RENT-M2000-VEJ' or $result->tiporenta == 'RENT-1COM-M2000-VEJ' or $result->tiporenta == 'RENT-1COMP-VEJ') 
                                    {                               
                                        $req = EconomicComplementRequirement::where('eco_com_type_id','=', 1 )->get();
                                        foreach ($req as $item) 
                                        {
                                            $sreq = new EconomicComplementSubmittedDocument;
                                            $sreq->economic_complement_id = $ecom->id;
                                            $sreq->eco_com_requirement_id = $item->id;
                                            $sreq->reception_date =  Carbon::createFromDate(2016, 7, 1);
                                            switch ($item->id) 
                                            {
                                                        case '1':
                                                                $sreq->status = false;
                                                                break;
                                                        case '2':
                                                                if($result->v_ci2 == "SI") {
                                                                    $sreq->status = true;
                                                                }
                                                                else{
                                                                    $sreq->status = false;
                                                                }
                                                            break;
                                                        case '3':
                                                                if($result->v_agra_servicio3 == "SI"){
                                                                    $sreq->status = true;
                                                                }
                                                                else{
                                                                    $sreq->status = false;
                                                                }
                                                            break;
                                                         case '4':
                                                                if($result->v_anos_servicio4 == "SI"){
                                                                    $sreq->status = true;
                                                                }
                                                                else{
                                                                    $sreq->status = false;
                                                                }
                                                            break;
                                                        
                                                        default:
                                                                if($result->v_resolucion_senasir5 == "SI") {
                                                                    $sreq->status = true;
                                                                }
                                                                else{
                                                                    $sreq->status = false;
                                                                }
                                                $sreq->save();         
                                            }
                                                                          
                                        }
                                        $vej++;        
                                    }
                                    elseif($result->tiporenta == 'VIUDEDAD' or $result->tiporenta == 'RENT-M2000-VIU' or $result->tiporenta == 'RENT-1COM-M2000-VIU' or $result->tiporenta == 'RENT-1COMP-VIU') //Viudedad
                                    {	     
                                        $req = EconomicComplementRequirement::where('eco_com_type_id','=', 2 )->get();
        	                            foreach ($req as $item) 
                                        {
        	                            	$sreq = new EconomicComplementSubmittedDocument;
        	                            	$sreq->economic_complement_id = $ecom->id;
        	                            	$sreq->eco_com_requirement_id = $item->id;
        	                            	$sreq->reception_date =  Carbon::createFromDate(2016, 7, 1);
                                            switch ($item->id) 
                                            {
                                                            case '6':
                                                                    $sreq->status = false;
                                                                    break;
                                                            case '7':
                                                                    if($result->viu_ci_causa7 == "SI") {
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }
                                                                break;
                                                            case '8':
                                                                    if($result->viu_ci_derecho8 == "SI") {
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }
                                                                break;

                                                            case '9':
                                                                    if($result->viu_defuncion9 == "SI") {
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }
                                                                break;
                                                            case '10':
                                                                    if($result->viu_senasir10 == "SI") {
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }
                                                                break;
                                                            case '11':
                                                                    if($result->viu_agra_servicio11 == "SI") {
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }
                                                                break;                                                
                                                            case '12':
                                                                    if($result->viu_anos_servicio12 == "SI") {
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }
                                                                break;

                                                            default:
                                                                    if($result->viu_matri13 == "SI"){
                                                                        $sreq->status = true;
                                                                    }
                                                                    else{
                                                                        $sreq->status = false;
                                                                    }

                             			                    
                                            $sreq->save();   
                                    		}
                                    	

                                    	}  
                                        
                                        $viu++;		                        		
                                    }
                                }
                             
                         
                    });
                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();

                $this->info("\n\nReport Update:\n
                $vej Vejez.\n
                $viu Viudadedad.\n
                $orf orfandad.\n               
                Execution time $execution_time [minutes].\n");
            }

        }
        else {
            $this->error('Incorrect password!');
            exit();
        }



    }
}
