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

class ImportComplement2015 extends Command implements SelfHandling
{
    protected $signature = 'import:complement2015';   
    protected $description = 'Importacion de trámites de complemento del 2015 1ER. y 2DO. SEMESTRE';

    public function handle()
    {	global $Progress,$nf,$f,$year,$semester,$mes,$dia,$abrev,$procedure_id;
    	$password = $this->ask('Enter the password');
    	if ($password == ACCESS) 
    	{
    		//$year = $this->ask('Enter the year');
            $semester = $this->ask('Enter the semester');
	        if($semester !== null)
            { 
	            $FolderName = $this->ask('Enter the name of the folder you want to import');

	            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) 
	            {   if($semester == "Primer")
	        		{
	        			(string)$abrev = "/P/";
	        			$mes = '1';
	        			$dia ='1';
	        			$procedure_id = 5;
	        		}
	        		else
	        		{
	        			(string)$abrev = "/S/";
	        			$mes = '7';
	        			$dia ='2';
	        			$procedure_id = 4;
	        		}
	        		
	                $time_start = microtime(true);
	                $this->info("Working...\n");
	                $Progress = $this->output->createProgressBar();                
	                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

	                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) 
	                {	global $Progress,$nf,$f,$year,$semester,$mes, $dia,$abrev,$procedure_id;
	                    $rows->each(function($result) 
	                    {
							global $Progress,$nf,$f,$year,$semester,$mes, $dia,$abrev,$procedure_id;
		                    ini_set('memory_limit', '-1');
		                    ini_set('max_execution_time', '-1');
		                    ini_set('max_input_time', '-1');
		                    set_time_limit('-1');
		                    $Progress->advance();
		                    
		                    //VEJEZ
	                        if($result->tiporenta == "RENT-1COM-M1656-VEJ" || $result->tiporenta == "RENT-1COMP-VEJ" || $result->tiporenta == "RENT-M1656-VEJ" || $result->tiporenta == "VEJEZ")
	                        {
	                        	//$afi = Affiliate::where('identity_card','=', strtoupper($result->ci))->first();
	                        	$afi = Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($result->ci),'0')."'")->first();
	                        	if($afi) //SI EXISTE AFILIADO
	                        	{
	                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2015)->where('semester', '=', $semester)->whereNull('deleted_at')->orderBy('id', 'desc')->first())                                      
	                    			{ 
	                    				$number_code = Util::separateCode($last_ecom->code);
	                                    $code = $number_code + 1;
	                                }
	                                else
	                                {
	                                	 $code = 1;
	                                }
	                                //verificando si ya existe el trámite
	                                $veri = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=', 'affiliates.id')
	                                							->where('economic_complements.affiliate_id','=',$afi->id)
	                                							->whereYear('economic_complements.year','=', 2015)
	                                							->where('semester','=',$semester)
	                                							->select('economic_complements.id', 'economic_complements.affiliate_id')->first();
	                                //dd($abrev);
	                                if(!$veri)
	                                {
					                    //creating eco com
					                    //dd($afi);
					            		$ecom = new EconomicComplement();
					            		$ecom->user_id = 1;
					                    $ecom->affiliate_id = $afi->id;
					                    //Asignacion de modalidad
			                            switch (trim($result->tiporenta)) 
			                            {                                	
			                            	case "RENT-1COM-M1656-VEJ":
			                            		$ecom->eco_com_modality_id = 6;
			                            		break;
			                            	case "RENT-1COMP-VEJ":
			                            		$ecom->eco_com_modality_id = 4;
			                            		break;
			                            	case "RENT-M1656-VEJ":
			                            		$ecom->eco_com_modality_id = 8;
			                            		break;
			                            	case "VEJEZ":
			                            		$ecom->eco_com_modality_id = 1;
			                            		break;                                	
			                            }
					                    
					                    $ecom->eco_com_procedure_id = $procedure_id;
					                    $ecom->workflow_id = 1;
					                    $ecom->wf_current_state_id = 4;
					                    $ecom->eco_com_state_id = 1;
					                    $ecom->city_id = Util::getRegionalCityId($result->regional);
					                    $ecom->year = Carbon::createFromDate(2015, $mes, $dia);
					                    $ecom->semester = $semester;
					                    $ecom->code = $code.$abrev."2015";                                                           
					                    $ecom->reception_date = Carbon::createFromDate(2015, $mes, $dia);
					                    $ecom->category_id = Util::getCategoryId($result->categoria);
					                    $ecom->degree_id = Util::getDegreeId(trim($result->grado));
					                    $ecom->state = 'Edited';
					                    $ecom->reception_type = $result->recepcion;
					                    //calculo
					                    $ecom->sub_total_rent = 0;
					                    $ecom->dignity_pension = 0;
					                    $ecom->reimbursement = 0;
					                    $ecom->total_rent = $result->renta_neta;				                    
					                    $ecom->salary_reference = $result->ref_sal;
					                    $ecom->seniority = $result->antiguedad;
					                    $ecom->salary_quotable = $result->cotizable;
					                    $ecom->difference = $result->diferencia;
					                    $ecom->total_amount_semester = $result->total_semestre;
					                    $ecom->complementary_factor = $result->factor_comp;				                   
					                    $ecom->total = $result->complemento_final;
					                    $ecom->save();

		                                //adding applicant to eco com
		                                $app = new EconomicComplementApplicant; 
		                                $app->economic_complement_id = $ecom->id;                                    
		                                $app->identity_card = $result->ci;
		                                $app->last_name = $afi->last_name;
		                                $app->mothers_last_name = $afi->mothers_last_name;
		                                $app->first_name = $afi->first_name;
		                                $app->second_name = $afi->second_name;
		                                $app->surname_husband = $afi->surname_husband;
		                                $app->birth_date = ($afi->birth_date) ? $afi->birth_date : null;
		                                $app->nua = ($afi->nua) ? $afi->nua : 0;
		                                $app->gender = $afi->gender;
		                                $app->civil_status = $afi->civil_status;
		                                $app->phone_number = $afi->phone_number;
		                                $app->cell_phone_number = $afi->cell_phone_number;
		                                $app->save();
		                                $f[] = $result;
	                                }
				                    
	                        	}
	                        	else
	                        	{
	                        		$nf[]=get_object_vars(json_decode($result));
	                        	}

	                        }
	                        elseif($result->tiporenta == "RENT-1COM-M1656-VIU" || $result->tiporenta == "RENT-1COMP-VIU" || $result->tiporenta == "RENT-M1656-VIU" || $result->tiporenta == "VIUDEDAD") //VIUDEDAD
	                        {
	                        	$benfi1 = EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')                        										  
	                        										  ->whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($result->ci),'0')."'")                        										
	                        										  ->whereIn('eco_com_modality_id',[2,5,7,9])
	                        										  ->select('economic_complements.id', 'economic_complements.affiliate_id')->first();
	                        	//dd($benfi1);
	                        	if($benfi1)
	                        	{
	                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2015)->where('semester', '=', $semester)->whereNull('deleted_at')->orderBy('id', 'desc')->first())                                      
	                    			{ 
	                    				$number_code = Util::separateCode($last_ecom->code);
	                                    $code = $number_code + 1;
	                                }
	                                else
	                                {
	                               	 $code = 1;
	                                }
				                   
				                    $eco = EconomicComplement::where('id','=',$benfi1->id)->first();
				                    $benfi = EconomicComplementApplicant::where('economic_complement_id','=',$eco->id)->first();
				                    $afi = Affiliate::where('id','=',$eco->affiliate_id)->first();
				                    //verificando si ya existe el 
	                                $veri = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=', 'affiliates.id')
	                                							->where('economic_complements.affiliate_id','=',$afi->id)
	                                							->whereYear('economic_complements.year','=', 2015)
	                                							->where('semester','=',$semester)
	                                							->select('economic_complements.id', 'economic_complements.affiliate_id')->first();
	                                //dd($);
	                                if(!$veri)
	                                {	
					                    //creating eco com
					            		$ecom = new EconomicComplement();
					            		$ecom->user_id = 1;
					                    $ecom->affiliate_id = $afi->id;
					                    //Asignacion de modalidad
		                                switch ($result->tiporenta) 
		                                {                                	
		                                	case "RENT-1COM-M1656-VIU":
		                                		$ecom->eco_com_modality_id = 7;
		                                		break;
		                                	case "RENT-1COMP-VIU":
		                                		$ecom->eco_com_modality_id = 5;
		                                		break;
		                                	case "RENT-M1656-VIU":
		                                		$ecom->eco_com_modality_id = 9;
		                                		break;
		                                	case "VIUDEDAD":
		                                		$ecom->eco_com_modality_id = 2;
		                                		break;                                	
		                                }
					                    
					                    $ecom->eco_com_procedure_id = $procedure_id;
					                    $ecom->workflow_id = 1;
					                    $ecom->wf_current_state_id = 4;
					                    $ecom->eco_com_state_id = 1;
					                    $ecom->city_id = Util::getRegionalCityId($result->regional);
					                    $ecom->year = Carbon::createFromDate(2015, $mes, $dia);
					                    $ecom->semester = $semester;
					                    $ecom->code = $code .$abrev."2015";                                                           
					                    $ecom->reception_date = Carbon::createFromDate(2015, $mes, $dia);			             
					                    $ecom->category_id = Util::getCategoryId($result->categoria);
					                    $ecom->degree_id = Util::getDegreeId(trim($result->grado));
					                    $ecom->state = 'Edited';
					                    $ecom->reception_type = $result->recepcion;
					                    //calculo
					                    $ecom->sub_total_rent = 0;
					                    $ecom->dignity_pension = 0;
					                    $ecom->reimbursement = 0;
					                    $ecom->total_rent = $result->renta_neta;				                    
					                    $ecom->salary_reference = $result->ref_sal;
					                    $ecom->seniority = $result->antiguedad;
					                    $ecom->salary_quotable = $result->cotizable;
					                    $ecom->difference = $result->diferencia;
					                    $ecom->total_amount_semester = $result->total_semestre;
					                    $ecom->complementary_factor = $result->factor_comp;				                   
					                    $ecom->total = $result->complemento_final;
					                    $ecom->save();

					                    //adding applicant to eco com
		                                $app = new EconomicComplementApplicant; 
		                                $app->economic_complement_id = $ecom->id;                                    
		                                $app->identity_card = $benfi->identity_card;
		                                $app->last_name = $benfi->last_name;
		                                $app->mothers_last_name = $benfi->mothers_last_name;
		                                $app->first_name = $benfi->first_name;
		                                $app->second_name = $benfi->second_name;
		                                $app->surname_husband = $benfi->surname_husband;
		                                $app->birth_date = ($benfi->birth_date) ? $benfi->birth_date : null;
		                                $app->nua = ($benfi->nua) ? $benfi->nua : 0;
		                                $app->gender = $benfi->gender;
		                                $app->civil_status = $benfi->civil_status;
		                                $app->phone_number = $benfi->phone_number;
		                                $app->cell_phone_number = $benfi->cell_phone_number;
		                                $app->save();
		                                $f[] = $result;
	                                }
				                    
	                        	}
	                        	else
	                        	{
	                        		$nf[]= get_object_vars(json_decode($result));
	                        	}
	                        }
	                        else
	                        {
	                        	$benfi = EconomicComplementApplicant::where('identity_card','=', strtoupper($result->ci))->first();
	                        	if($benfi)
	                        	{
	                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2015)->where('semester', '=', $semester)->whereNull('deleted_at')->orderBy('id', 'desc')->first())                                      
	                    			{ 
	                    				$number_code = Util::separateCode($last_ecom->code);
	                                    $code = $number_code + 1;
	                                }
	                                else
	                                {
	                                	 $code = 1;
	                                }
				                    
				                    $eco = EconomicComplement::where('id','=',$benfi->economic_complement_id)->first();
				                    $afi = Affiliate::where('id','=',$eco->affiliate_id)->first();

				                     $veri = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=', 'affiliates.id')
	                                							->where('economic_complements.affiliate_id','=',$afi->id)
	                                							->whereYear('economic_complements.year','=', 2015)
	                                							->where('semester','=',$semester)
	                                							->select('economic_complements.id', 'economic_complements.affiliate_id')->first();
	                                if(!$veri)
	                                {
					                    //creating eco com
					            		$ecom = new EconomicComplement();
					            		$ecom->user_id = 1;
					                    $ecom->affiliate_id = $afi->id;
					                    //Asignacion de modalidad
		                                switch ($result->tiporenta) 
		                                {                           	
		                                	
		                                	case "ORFANDAD":
		                                		$ecom->eco_com_modality_id = 3;
		                                		break;                                	
		                                }
					                    
					                    $ecom->eco_com_procedure_id = $procedure_id;
					                    $ecom->workflow_id = 1;
					                    $ecom->wf_current_state_id = 4;
					                    $ecom->eco_com_state_id = 1;
					                    $ecom->city_id = Util::getRegionalCityId($result->regional);
					                    $ecom->year = Carbon::createFromDate(2015, $mes, $dia);
					                    $ecom->semester = $semester;
					                    $ecom->code = $code .$abrev."2015";                                                           
					                    $ecom->reception_date = Carbon::createFromDate(2015, $mes, $dia);			                   
					                    $ecom->category_id = Util::getCategoryId($result->categoria);
						                $ecom->degree_id = Util::getDegreeId(trim($result->grado));
					                    $ecom->state = 'Edited';
					                    $ecom->reception_type = $result->recepcion;
					                    //calculo
					                    $ecom->sub_total_rent = 0;
					                    $ecom->dignity_pension = 0;
					                    $ecom->reimbursement = 0;
					                    $ecom->total_rent = $result->renta_neta;				                    
					                    $ecom->salary_reference = $result->ref_sal;
					                    $ecom->seniority = $result->antiguedad;
					                    $ecom->salary_quotable = $result->cotizable;
					                    $ecom->difference = $result->diferencia;
					                    $ecom->total_amount_semester = $result->total_semestre;
					                    $ecom->complementary_factor = $result->factor_comp;				                   
					                    $ecom->total = $result->complemento_final;
					                    $ecom->save();

					                    //adding applicant to eco com
		                                $app = new EconomicComplementApplicant; 
		                                $app->economic_complement_id = $ecom->id;                                    
		                                $app->identity_card = $benfi->identity_card;
		                                $app->last_name = $benfi->last_name;
		                                $app->mothers_last_name = $benfi->mothers_last_name;
		                                $app->first_name = $benfi->first_name;
		                                $app->second_name = $benfi->second_name;
		                                $app->surname_husband = $benfi->surname_husband;
		                                $app->birth_date = ($benfi->birth_date) ? $benfi->birth_date : null;
		                                $app->nua = ($benfi->nua) ? $benfi->nua : 0;
		                                $app->gender = $benfi->gender;
		                                $app->civil_status = $benfi->civil_status;
		                                $app->phone_number = $benfi->phone_number;
		                                $app->cell_phone_number = $benfi->cell_phone_number;
		                                $app->save();
		                                $f[] = $result;
		                            }
	                        	}
	                        	else
	                        	{
	                        		$nf[]= get_object_vars(json_decode($result));
	                        	}

	                        }

	                    });
	                });

					//exportando a excel los tramites que no se importaron
					Excel::create('NOIMPORTADO'.$semester, function($excel) use($nf) 
					{
						global $Progress,$nf,$f,$semester;
					    $excel->sheet('NOTFOUND', function($sheet) use($nf) 
					    {
					    	global $Progress,$nf,$f;
					        $sheet->fromArray($nf);

					    });

					})->store('xls', storage_path('excel/exports'));;; 

	                $time_end = microtime(true);
	                $execution_time = ($time_end - $time_start)/60;
	                $Progress->finish();

	                $this->info("\n\nReport Update:\n
	                ".sizeof($nf)." Tramites que se no importaron.\n
	                ".sizeof($f)." Tramites importados.\n
	                Execution time $execution_time [minutes].\n");

           		}
           	}
           	else
           	{
           		$this->error('Ingrese año y semestre!');
            	exit();
           	}
        }
        else 
        {
            $this->error('Incorrect password!');
            exit();
        }

	







	}
}
