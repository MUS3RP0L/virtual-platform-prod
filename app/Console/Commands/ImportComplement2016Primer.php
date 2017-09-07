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
use Log;

class ImportComplement2016Primer extends Command implements SelfHandling
{
    protected $signature = 'import:complement2016';   
    protected $description = 'Importacion de trámites de complemento del 2015 1ER. y 2DO. SEMESTRE';

    public function handle()
    {	global $Progress,$nf,$f;
    	$password = $this->ask('Enter the password');
    	if ($password == ACCESS) 
    	{

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) 
            {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();                
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) 
                {	global $Progress,$nf,$f;
                    $rows->each(function($result) 
                    {
						global $Progress,$nf,$f;
	                    ini_set('memory_limit', '-1');
	                    ini_set('max_execution_time', '-1');
	                    ini_set('max_input_time', '-1');
	                    set_time_limit('-1');
	                    $Progress->advance();

	                    //VEJEZ
	                   // dd($result->tiporenta);
                        if($result->tiporenta == "RENT-1COM-M2000-VEJ" || $result->tiporenta == "RENT-1COMP-VEJ" || $result->tiporenta =="RENT-M2000-VEJ" || $result->tiporenta =="VEJEZ")
                        {	
                        	$afi = Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($result->ci_derecho),'0')."'")->first();
                        	

                        	if(!$afi) //SI no EXISTE AFILIADO
                        	{
                               
			                    $affiliate = new Affiliate;
			                    $affiliate->user_id = 1;
			                    $affiliate->affiliate_state_id = 5;
			                    $affiliate->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
			                    $affiliate->identity_card = trim($result->ci_derecho);
			                    $affiliate->category_id = Util::getCategoryId($result->categoria);
			                    $affiliate->type = 'Comando';
			                    $affiliate->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);
			                    $affiliate->city_birth_id = Util::getRegionalCityExtId($result->ext);
			                    $affiliate->degree_id = Util::getDegreeId($result->grado);
			                    				

			                    $affiliate->last_name = trim($result->Apellido_Paterno);
			                    $affiliate->mothers_last_name = trim($result->Apellido_Materno);
			                    $affiliate->first_name = trim($result->pNombre);
			                    $affiliate->second_name = trim($result->sNombre);
			                    $affiliate->surname_husband = trim($result->Apellido_Casada);
			                    $affiliate->gender = 'M';
			                    $affiliate->nua = 0;
			                   // $affiliate->birth_date = Util::datePick($result->birth_date);
			                    $affiliate->civil_status = 'C';
			                    $affiliate->change_date = Carbon::now();
			                    /*$affiliate->phone_number = trim(implode(",", $result->phone_number));
			                    $affiliate->cell_phone_number = trim(implode(",", $result->cell_phone_number));
			                    $affiliate->registration = Util::CalcRegistration($affiliate->birth_date, $affiliate->last_name, $affiliate->mothers_last_name, $affiliate->first_name, $affiliate->gender);*/
			                    $affiliate->save();

			                     if ($last_ecom = EconomicComplement::whereYear('year', '=', 2016)->where('semester', '=', 'Primer')->whereNull('deleted_at')->orderBy('id', 'desc')->first())                                      
                    			{ 
                    				$number_code = Util::separateCode($last_ecom->code);
                                    $code = $number_code + 1;
                                }
                                else
                                {
                                	 $code = 1;
                                }

			                    //create complment
			            		$ecom = new EconomicComplement();
			            		$ecom->user_id = 1;
			                    $ecom->affiliate_id = $affiliate->id;
			                    //Asignacion de modalidad
	                            switch ($result->tiporenta) 
	                            {                                	
	                            	case "RENT-1COM-M2000-VEJ":
	                            		$ecom->eco_com_modality_id = 6;
	                            		break;
	                            	case "RENT-1COMP-VEJ":
	                            		$ecom->eco_com_modality_id = 4;
	                            		break;
	                            	case "RENT-M2000-VEJ":
	                            		$ecom->eco_com_modality_id = 8;
	                            		break;
	                            	case "VEJEZ":
	                            		$ecom->eco_com_modality_id = 1;
	                            		break;                                	
	                            }
			                    $ecom->eco_com_modality_id = 1;
			                    $ecom->eco_com_procedure_id = 3;
			                    $ecom->workflow_id = 1;
			                    $ecom->wf_current_state_id = 4;
			                    $ecom->eco_com_state_id = 1;
			                    $ecom->city_id = Util::getRegionalCityId($result->regional);
			                    $ecom->year = Carbon::createFromDate(2016, 1, 1);
			                    $ecom->semester = 'Primer';
			                    $ecom->code = $code ."/P/" ."2016";                                                           
			                    $ecom->reception_date = Carbon::createFromDate(2016, 1, 2);
			                    $ecom->category_id = Util::getCategoryId($result->categoria);
			                    $ecom->degree_id = Util::getDegreeId(trim($result->grado));
			                    $ecom->state = 'Edited';
			                    $ecom->reception_type = $result->recepcion;
			                    //calculo
			                    $ecom->sub_total_rent = $result->renta_boleta;
			                    $ecom->dignity_pension = $result->dignidad;
			                    $ecom->reimbursement = $result->reintegro;

			                    $ecom->total_rent = $result->renta_neta;
			                    $ecom->total_rent_calc = $result->promedio;				                    
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
                                $app->city_identity_card_id = $affiliate->city_identity_card_id;
                                $app->last_name = $affiliate->last_name;
                                $app->mothers_last_name = $affiliate->mothers_last_name;
                                $app->first_name = $affiliate->first_name;
                                $app->second_name = $affiliate->second_name;
                                $app->surname_husband = $affiliate->surname_husband;

                               // $app->birth_date = ($affiliate->birth_date) ? $affiliate->birth_date : null;
                                $app->nua =  $affiliate->nua;
                                $app->gender = $affiliate->gender;
                                $app->civil_status = $affiliate->civil_status;
			                   // $affiliate->birth_date = Util::datePick($result->birth_date);
                                /*$app->phone_number = $affiliate->phone_number;
                                $app->cell_phone_number = $affiliate->cell_phone_number;*/
                                $app->save();
                        	}
                        	else
                        	{
                        		 if ($last_ecom = EconomicComplement::whereYear('year', '=', 2016)->where('semester', '=', 'Primer')->whereNull('deleted_at')->orderBy('id', 'desc')->first())                                      
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
                                							->whereYear('economic_complements.year','=', 2016)
                                							->where('semester','=','Primer')
                                							->select('economic_complements.id', 'economic_complements.affiliate_id')->first();
                                if(!$veri)
                                {
				                    
				            		$ecom = new EconomicComplement();
				            		$ecom->user_id = 1;
				                    $ecom->affiliate_id = $afi->id;
				                    //Asignacion de modalidad
		                            switch ($result->tiporenta) 
		                            {                                	
		                            	case "RENT-1COM-M2000-VEJ":
		                            		$ecom->eco_com_modality_id = 6;
		                            		break;
		                            	case "RENT-1COMP-VEJ":
		                            		$ecom->eco_com_modality_id = 4;
		                            		break;
		                            	case "RENT-M2000-VEJ":
		                            		$ecom->eco_com_modality_id = 8;
		                            		break;
		                            	case "VEJEZ":
		                            		$ecom->eco_com_modality_id = 1;
		                            		break;                                	
		                            }
				                    $ecom->eco_com_modality_id = 1;
				                    $ecom->eco_com_procedure_id = 3;
				                    $ecom->workflow_id = 1;
				                    $ecom->wf_current_state_id = 4;
				                    $ecom->eco_com_state_id = 1;
				                    $ecom->city_id = Util::getRegionalCityId($result->regional);
				                    $ecom->year = Carbon::createFromDate(2016, 1, 1);
				                    $ecom->semester = 'Primer';
				                    $ecom->code = $code ."/P/" ."2016";                                                           
				                    $ecom->reception_date = Carbon::createFromDate(2016, 1, 2);
				                    $ecom->category_id = Util::getCategoryId($result->categoria);
				                    $ecom->degree_id = Util::getDegreeId(trim($result->grado));
				                    $ecom->state = 'Edited';
				                    $ecom->reception_type = $result->recepcion;
				                    //calculo				                   
				                    $ecom->sub_total_rent = $result->renta_boleta;
				                    $ecom->dignity_pension = $result->dignidad;
				                    $ecom->reimbursement = $result->reintegro;

				                    $ecom->total_rent = $result->renta_neta;
				                    $ecom->total_rent_calc = $result->promedio;					                    
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
	                                $app->city_identity_card_id = $afi->city_identity_card_id;
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

                        }
                        elseif($result->tiporenta == "RENT-1COM-M2000-VIU" || $result->tiporenta == "RENT-1COMP-VIU" || $result->tiporenta == "RENT-M2000-VIU" || $result->tiporenta == "VIUDEDAD") //VIUDEDAD
                        {
                        	//$afi = Affiliate::where('identity_card','=', strtoupper($result->ci_causa))->first();
                        	$afi = Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($result->ci_causa),'0')."'")->first();
                        	
                        	if($afi)
                        	{
                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2016)->where('semester', '=', 'Primer')->whereNull('deleted_at')->orderBy('id', 'desc')->first())                                      
                    			{ 
                    				$number_code = Util::separateCode($last_ecom->code);
                                    $code = $number_code + 1;
                                }
                                else
                                {
                               	 	$code = 1;
                                }

			                          
                                //verificando si ya existe el 
                               
                                $veri = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=', 'affiliates.id')
                                							->where('economic_complements.affiliate_id','=',$afi->id)
                                							->whereYear('economic_complements.year','=', 2016)
                                							->where('semester','=','Primer')
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
	                                	case "RENT-1COM-M2000-VIU":
	                                		$ecom->eco_com_modality_id = 7;
	                                		break;
	                                	case "RENT-1COMP-VIU":
	                                		$ecom->eco_com_modality_id = 5;
	                                		break;
	                                	case "RENT-M2000-VIU":
	                                		$ecom->eco_com_modality_id = 9;
	                                		break;
	                                	case "VIUDEDAD":
	                                		$ecom->eco_com_modality_id = 2;
	                                		break;                                	
	                                }				                    
				                    $ecom->eco_com_procedure_id = 3;
				                    $ecom->workflow_id = 1;
				                    $ecom->wf_current_state_id = 4;
				                    $ecom->eco_com_state_id = 1;
				                    $ecom->city_id = Util::getRegionalCityId($result->regional);
				                    $ecom->year = Carbon::createFromDate(2016, 1, 1);
				                    $ecom->semester = 'Primer';
				                    $ecom->code = $code ."/P/" ."2016";                                                           
				                    $ecom->reception_date = Carbon::createFromDate(2016, 1, 2);				             
				                    $ecom->category_id = Util::getCategoryId($result->categoria);
				                    $ecom->degree_id = Util::getDegreeId(trim($result->grado));
				                    $ecom->state = 'Edited';
				                    $ecom->reception_type = $result->recepcion;
				                    //calculo				                    
				                    $ecom->sub_total_rent = $result->renta_boleta;
				                    $ecom->dignity_pension = $result->dignidad;
				                    $ecom->reimbursement = $result->reintegro;

				                    $ecom->total_rent = $result->renta_neta;
				                    $ecom->total_rent_calc = $result->promedio;					                    
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
	                                $app->identity_card = $result->ci_derecho;
	                                $app->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
	                                $app->last_name = $result->Apellido_Paterno;
	                                $app->mothers_last_name = $result->Apellido_Materno;
	                                $app->first_name = $result->pNombre;
	                                $app->second_name = $result->sNombre;
	                                $app->surname_husband = $result->Apellido_Casada;
	                                /*$app->birth_date = ($benfi->birth_date) ? $benfi->birth_date : null;
	                                $app->nua = ($benfi->nua) ? $benfi->nua : 0;
	                                $app->gender = $benfi->gender;
	                                $app->civil_status = $benfi->civil_status;
	                                $app->phone_number = $benfi->phone_number;
	                                $app->cell_phone_number = $benfi->cell_phone_number;*/
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
                        	$afi= Affiliate::whereRaw("ltrim(trim(identity_card),'0')='".ltrim(trim($result->ci_causa),'0')."'")->first();
                        	if($afi)
                        	{
                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2016)
                                									->where('semester', '=', 'Primer')
                                									->whereNull('deleted_at')
                                									->orderBy('id', 'desc')->first())                                      
                    			{ 
                    				$number_code = Util::separateCode($last_ecom->code);
                                    $code = $number_code + 1;
                                }
                                else
                                {
                                	 $code = 1;
                                }
			                    

			                    $veri = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=', 'affiliates.id')
                                							->where('economic_complements.affiliate_id','=',$afi->id)
                                							->whereYear('economic_complements.year','=', 2016)
                                							->where('semester','=','Primer')
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
				                    
				                    $ecom->eco_com_procedure_id = 3;
				                    $ecom->workflow_id = 1;
				                    $ecom->wf_current_state_id = 4;
				                    $ecom->eco_com_state_id = 1;
				                    $ecom->city_id = Util::getRegionalCityId($result->regional);
				                    $ecom->year = Carbon::createFromDate(2016, 1, 1);
				                    $ecom->semester = 'Primer';
				                    $ecom->code = $code ."/P/" ."2016";                                                          
				                    $ecom->reception_date = Carbon::createFromDate(2016, 1, 2);			                   
				                    $ecom->category_id = Util::getCategoryId($result->categoria);
					                $ecom->degree_id = Util::getDegreeId(trim($result->grado));
				                    $ecom->state = 'Edited';
				                    $ecom->reception_type = $result->recepcion;
				                    //calculo				                   
				                    $ecom->sub_total_rent = $result->renta_boleta;
				                    $ecom->dignity_pension = $result->dignidad;
				                    $ecom->reimbursement = $result->reintegro;

				                    $ecom->total_rent = $result->renta_neta;
				                    $ecom->total_rent_calc = $result->promedio;					                    
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
	                                $app->identity_card = $result->ci_derecho;	                                
	                                $app->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
	                                $app->last_name = $result->Apellido_Paterno;
	                                $app->mothers_last_name = $result->Apellido_Materno;
	                                $app->first_name = $result->pnombre;
	                                $app->second_name = $result->snombre;
	                                $app->surname_husband = $result->Apellido_Casada;
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
				//Log::info($nf);
				//exportando a excel los tramites que no se importaron
				Excel::create('NF', function($excel) use($nf) 
				{
					global $Progress,$nf,$f;
				    $excel->sheet('Sheetname', function($sheet) use($nf) 
				    {


				    	global $Progress,$nf,$f;
				        $sheet->fromArray($nf);

				    });

				})->store('xls', storage_path('excel/exports'));; 

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
            $this->error('Incorrect password!');
            exit();
        }

	







	}
}
