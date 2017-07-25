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

class ImportRegional extends Command implements SelfHandling
{
    protected $signature = 'import:regional';   
    protected $description = 'Importacion Regional';

    public function handle()
    {
    	global $Progress,$veha,$vein,$viha,$viin,$exvej,$exviu;
        
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
							global $Progress,$veha,$vein,$viha,$viin,$exvej,$exviu;
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
                            $Progress->advance();                
                            //vejez                        
                          

                            if ($result->tiporenta == 'VEJEZ') 
                            {	$ecom1 = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')->where('identity_card','=', strtoupper($result->ci))->whereYear('year','=',2017)->where('semester','=', 'Primer')->select('affiliates.identity_card')->first();	
                            	if(!$ecom1)
                            	{	
	                            	if ($result->tipotramite == 'HABITUAL' ) 
	                            	{
		                            	//para habituales vejez
		                            	$afi = Affiliate::where('identity_card','=',strtoupper($result->ci))->first();
		                            	if ($afi) 
		                            	{
		                            		/*if ($last_ecom = EconomicComplement::all()->last()) {
			                                    $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                }*/
			                                if(!$afi->pension_entity_id)
			                                {
			                                	$afi->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);
			                                	$afi->save();
			                                }
			                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2017)
                                                    ->where('semester', '=', 'Primer')
                                                    ->whereNull('deleted_at')->orderBy('id', 'desc')->first())
                                			{ $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                }
			                                //creating eco com
		                            		$ecom = new EconomicComplement();
		                            		$ecom->user_id = 1;
			                                $ecom->affiliate_id = $afi->id;
			                                $ecom->eco_com_modality_id = 1;
			                                $ecom->eco_com_procedure_id = 2;
			                                $ecom->workflow_id = 1;
			                                $ecom->wf_current_state_id = 1;
			                                $ecom->city_id = Util::getRegionalCityId($result->regional);
			                                $ecom->year = Carbon::createFromDate(Carbon::now()->year, 7, 1);
			                                $ecom->semester = 'Primer';
			                                $ecom->code = $code ."/P/" . Carbon::now()->year;                                                           
			                                $ecom->reception_date = Carbon::createFromDate(Carbon::now()->year, 7, 7);
			                                $ecom->category_id = $afi->category_id;
			                                $ecom->state = 'Edited';
			                                $ecom->reception_type = 'Habitual';
			                                $ecom->save();

			                                //adding applicant to eco com
			                                $app = new EconomicComplementApplicant; 
			                                $app->economic_complement_id = $ecom->id;               
			                                $app->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
			                                $app->identity_card = $result->ci;
			                                $app->last_name = $afi->last_name;
			                                $app->mothers_last_name = $afi->mothers_last_name;
			                                $app->first_name = $afi->first_name;
			                                $app->second_name = $afi->second_name;
			                                $app->surname_husband = $afi->surname_husband;
			                                $app->birth_date = ($result->fecha_nac) ? $result->fecha_nac : null;;
			                                if ($result->ente_gestor == 'SENASIR') {
				                                $app->nua = 0;
			                                }else{
			                                	$app->nua = $afi->nua;
			                                }
			                                $app->gender = $afi->gender;
			                                $app->civil_status = $afi->civil_status;
			                                $app->phone_number = $result->fijo;
			                                $app->cell_phone_number = $result->celular;
			                                $app->save();

			                                //añadiendo requisitos
			                                $req = EconomicComplementRequirement::where('eco_com_type_id','=', 1 )->get();
			                                foreach ($req as $item) 
			                                {   
			                                	if ($item->id < 3) {
			                                		# code...
			                                        $submit = new EconomicComplementSubmittedDocument;
			                                        $submit->economic_complement_id = $ecom->id;
			                                        $submit->eco_com_requirement_id = $item->id;
			                                        $submit->reception_date =  Carbon::createFromDate(2017, 7, 7);
			                                        switch ($item->id) 
			                                        {
	                                                    case "1":
	                                                       	$submit->status =  ($result->h_ci == "SI");  
	                                                        break;
	                                                    case "2":
	                                                       	$submit->status =  ($result->h_boleta == "SI");  
															break;
	                                                    default:
	                                                       
	                                                        break;
			                                        }
			                                       $submit->save();             
			                                	
			                                	}
			                                }
			                                
		                            	}
		                            	else
		                            	{
		                            		$veha[] = $result;
		                            	}
	                            	}
	                            	else
	                            	{
		                            	//para inclusiones vejez
	                            		$afi = Affiliate::where('identity_card','=',strtoupper($result->ci))->first();
		                            	if (!$afi) {
		                            		$afi = new Affiliate();
		                            		$afi->user_id = 1;
		                            		$afi->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
		                            		$afi->identity_card = ltrim($result->ci);
		                            		$afi->affiliate_state_id = 5;
		                            		$afi->degree_id = Util::getDegreeId($result->grado);
		                            		$afi->category_id = Util::getCategoryId($result->categoria);
		                            		$afi->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);
		                            		$afi->registration ='0';
		                            		$afi->type = 'Comando';
		                            		$afi->last_name = $result->pat;
		                            		$afi->mothers_last_name = $result->mat;
		                            		$afi->first_name = $result->pnom;
		                            		$afi->second_name = $result->snom;
		                            		$afi->surname_husband = $result->apes;
		                            		$afi->gender ='M';
		                            		$afi->civil_status = Util::getCivilStatus($result->eciv);
		                            		$afi->birth_date = $result->fecha_nac;
		                            		if ($result->ente_gestor == 'SENASIR') {
				                                $afi->nua = 0;
			                                }else{
			                                	$afi->nua = $result->nua_cua;
			                                }
		                            		$afi->change_date = Carbon::createFromDate(Carbon::now()->year, 7, 7);
		                            		$afi->phone_number = $result->fijo;
		                            		$afi->cell_phone_number = $result->celular;
		                            		$afi->save();
		                            		$vein[] = $result;
		                            	}
		                            	elseif(!$afi->pension_entity_id)
			                            {
			                                	$afi->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);
			                                	$afi->save();
			                            }
		                            		//obteniendo el ultimo code
		                            		/*if ($last_ecom = EconomicComplement::all()->last()) {
			                                    $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;

			                                }*/
			                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2017)
                                                    ->where('semester', '=', 'Primer')
                                                    ->whereNull('deleted_at')->orderBy('id', 'desc')->first())
                                			{ $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                }
			                                //creating eco com
		                            		$ecom = new EconomicComplement();
		                            		$ecom->user_id = 1;
			                                $ecom->affiliate_id = $afi->id;                 
			                                $ecom->eco_com_modality_id = 1;
			                                $ecom->eco_com_procedure_id = 2;
			                                $ecom->workflow_id = 1;
			                                $ecom->wf_current_state_id = 1;
			                                $ecom->city_id = Util::getRegionalCityId($result->regional);
			                                $ecom->year = Carbon::createFromDate(Carbon::now()->year, 7, 1);
			                                $ecom->semester = 'Primer';
			                                $ecom->code = $code ."/P/" . Carbon::now()->year;                                                           
			                                $ecom->reception_date = Carbon::createFromDate(Carbon::now()->year, 7, 7);
			                                $ecom->category_id = $afi->category_id;
			                                $ecom->state = 'Edited';
			                                $ecom->reception_type = 'Inclusion';
			                                $ecom->save();

			                                //adding applicant to eco com
			                                $app = new EconomicComplementApplicant; 
			                                $app->economic_complement_id = $ecom->id;               
			                                $app->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
			                                $app->identity_card = $result->ci;
			                                $app->last_name = $afi->last_name;
			                                $app->mothers_last_name = $afi->mothers_last_name;
			                                $app->first_name = $afi->first_name;
			                                $app->second_name = $afi->second_name;
			                                $app->surname_husband = $afi->surname_husband;
			                                $app->birth_date = $result->fecha_nac;
			                                if ($result->ente_gestor == 'SENASIR') {
				                                $app->nua = 0;
			                                }else{
			                                	$app->nua = $result->nua_cua;
			                                }
			                                $app->civil_status = $afi->civil_status;
			                                $app->phone_number = $result->fijo;
			                                $app->cell_phone_number = $result->celular;
			                                $app->save();

			                                //añadiendo requisitos
			                                $req = EconomicComplementRequirement::where('eco_com_type_id','=', 1 )->get();
			                                foreach ($req as $item) 
			                                {   
		                                        $submit = new EconomicComplementSubmittedDocument;
		                                        $submit->economic_complement_id = $ecom->id;
		                                        $submit->eco_com_requirement_id = $item->id;
		                                        $submit->reception_date =  Carbon::createFromDate(2017, 7, 7);

		                                        switch ($item->id) 
		                                        {
		                                        	case "1":
		                                        		$submit->status = ($result->iv_boleta == 'SI');
		                                        		break;
		                                        	case "2":
		                                        		$submit->status = ($result->iv_ci == 'SI');
		                                        		break;
		                                        	case "3":
		                                        		$submit->status = ($result->iv_memo == 'SI');
		                                        		break;
		                                        	case "4":
		                                        		$submit->status = ($result->iv_anioserv == 'SI');
		                                        		break;
		                                        	case "5":
		                                        		$submit->status = ($result->iv_senasir_afp == 'SI');
		                                        		break;
	                                                default:
	                                                    $submit->status = false;
	                                                    break;
		                                        }
		                                        $submit->save();
			                                }
		                            	
	                            	}
	                            }
	                            else
	                            {
	                            	$exvej[] = $ecom1;
	                            }
                            }

                            else if($result->tiporenta == 'VIUDEDAD')
                            {
                            	
                            	$ecom1 = EconomicComplement::leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')->where('identity_card','=', strtoupper($result->ci_ch))->whereYear('year','=',2017)->where('semester','=', 'Primer')->select('affiliates.identity_card')->first();	                            	                            	
                            	
                            	if(!$ecom1)
                            	{	
	                            	if ($result->tipotramite == 'HABITUAL' ) 
	                            	{
		                            	//para habituales viudedad
		                            	$afi = Affiliate::where('identity_card','=',strtoupper($result->ci_ch))->first();
		                            	if ($afi) 
		                            	{
		                            		/*if ($last_ecom = EconomicComplement::all()->last()) {
			                                    $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                    dd($code);
			                                }*/
			                                if(!$afi->pension_entity_id)
			                                {
			                                	$afi->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);
			                                	$afi->save();
			                                }
			                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2017)
                                                    ->where('semester', '=', 'Primer')
                                                    ->whereNull('deleted_at')->orderBy('id', 'desc')->first())
                                			{ $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                }
			                                //creating eco com
		                            		$ecom = new EconomicComplement();
		                            		$ecom->user_id = 1;
			                                $ecom->affiliate_id = $afi->id;                 
			                                $ecom->eco_com_modality_id = 2;
			                                $ecom->eco_com_procedure_id = 2;
			                                $ecom->workflow_id = 1;
			                                $ecom->wf_current_state_id = 1;
			                                $ecom->city_id = Util::getRegionalCityId($result->regional);
			                                $ecom->year = Carbon::createFromDate(Carbon::now()->year, 7, 1);
			                                $ecom->semester = 'Primer';
			                                $ecom->code = $code ."/P/" . Carbon::now()->year;                                                           
			                                $ecom->reception_date = Carbon::createFromDate(Carbon::now()->year, 7, 7);
			                                $ecom->category_id = $afi->category_id;
			                                $ecom->state = 'Edited';
			                                $ecom->reception_type = 'Habitual';
			                                $ecom->save();
			                                
			                                //adding applicant to eco com
			                                $app = new EconomicComplementApplicant; 
			                                $app->economic_complement_id = $ecom->id;               
			                                $app->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
			                                $app->identity_card = $result->ci;
			                                $app->last_name = $result->pat;
			                                $app->mothers_last_name = $result->mat;
			                                $app->first_name = $result->pnom;
			                                $app->second_name = $result->snom;
			                                $app->surname_husband = $result->apes;
			                                $app->birth_date = $result->fecha_nac;
			                                if ($result->ente_gestor == 'SENASIR') {
				                                $app->nua = 0;
			                                }else{
			                                	$app->nua = $afi->nua;
			                                }
			                                $app->civil_status = Util::getCivilStatus($result->eciv);
			                                $app->phone_number = $result->fijo;
			                                $app->cell_phone_number = $result->celular;
			                                $app->save();

			                                //añadiendo requisitos
			                                $req = EconomicComplementRequirement::where('eco_com_type_id','=', 2 )->get();
			                                foreach ($req as $item) 
			                                {   
			                                	if ($item->id == 6 ||$item->id == 8 ||$item->id == 13 ) {
			                                		# code...
		                                        $submit = new EconomicComplementSubmittedDocument;
		                                        $submit->economic_complement_id = $ecom->id;
		                                        $submit->eco_com_requirement_id = $item->id;
		                                        $submit->reception_date =  Carbon::createFromDate(2017, 7, 7);
		                                        switch ($item->id) 
		                                        {
	                                                case "6":
	                                                   	$submit->status =  ($result->h_ci == "SI");  
	                                                    break;
	                                                case "8":
	                                                   	$submit->status =  ($result->h_boleta == "SI");  
														break;
													case "13":
	                                                   	$submit->status =  ($result->h_sereci == "SI");  
														break;
	                                                default:	                                                   
	                                                    break;
		                                        }
		                                        $submit->save();
			                                	}
			                                }
		                            	}else{
		                            		$viha[] = $result;
		                            	}
	                            	}
	                            	else
	                            	{
		                            	//para inclusiones viudas		                            	
	                            		$afi = Affiliate::where('identity_card','=',strtoupper($result->ci_ch))->first();
		                            	if (!$afi) 
		                            	{		                            		
		                            		$afi = new Affiliate();
		                            		$afi->user_id = 1;		                            		
		                            		$afi->city_identity_card_id = Util::getRegionalCityExtId($result->ext_ch);
		                            		$afi->identity_card = ltrim($result->ci_ch);
		                            		$afi->affiliate_state_id = 5;                    		
		                            			                            		
		                            		$afi->degree_id = Util::getDegreeId($result->grado);		                            		
		                            		$afi->category_id = Util::getCategoryId($result->categoria);		                            		
		                            		$afi->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);

		                            		$afi->registration ='0';
		                            		$afi->type = 'Comando';

		                            		$afi->last_name = $result->pat_ch;
		                            		$afi->mothers_last_name = $result->mat_ch;
		                            		$afi->first_name = $result->pnom_ch;
		                            		$afi->second_name = $result->snom_ch;
		                            		$afi->surname_husband = $result->apes_ch;		                            		//$afi->gender //falta/;
		                            		$afi->gender ='F';
		                            		if ($result->ente_gestor == 'SENASIR') {
				                                $afi->nua = 0;
			                                }else{
			                                	$afi->nua = $result->nua_cua;
			                                }
		                            		$afi->change_date = Carbon::createFromDate(Carbon::now()->year, 7, 7);
		                            		$afi->phone_number = $result->fijo;
		                            		$afi->cell_phone_number = $result->celular;
		                            		$afi->save();
		                            		$viin[] = $result;
		                            	}
		                            	elseif(!$afi->pension_entity_id)
			                            {
			                                	$afi->pension_entity_id = Util::getEntityPensionId($result->ente_gestor);
			                                	$afi->save();
			                            }
		                            		//obteniendo el ultimo code
		                            		/*if ($last_ecom = EconomicComplement::all()->last()) {
			                                    $number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                }*/
			                                if ($last_ecom = EconomicComplement::whereYear('year', '=', 2017)
                                                    ->where('semester', '=', 'Primer')
                                                    ->whereNull('deleted_at')->orderBy('id', 'desc')->first())
                                			{ 	$number_code = Util::separateCode($last_ecom->code);
			                                    $code = $number_code + 1;
			                                }
			                                //creating eco com
		                            		$ecom = new EconomicComplement();
		                            		$ecom->user_id = 1;
			                                $ecom->affiliate_id = $afi->id;                 
			                                $ecom->eco_com_modality_id = 2;
			                                $ecom->eco_com_procedure_id = 2;
			                                $ecom->workflow_id = 1;
			                                $ecom->wf_current_state_id = 1;
			                                $ecom->city_id = Util::getRegionalCityId($result->regional);
			                                $ecom->year = Carbon::createFromDate(Carbon::now()->year, 7, 1);
			                                $ecom->semester = 'Primer';
			                                $ecom->code = $code ."/P/" . Carbon::now()->year;                                                           
			                                $ecom->reception_date = Carbon::createFromDate(Carbon::now()->year, 7, 7);
			                                $ecom->category_id = $afi->category_id;
			                                $ecom->state = 'Edited';
			                                $ecom->reception_type = 'Inclusion';
			                                $ecom->save();

			                                //adding applicant to eco com
			                                $app = new EconomicComplementApplicant; 
			                                $app->economic_complement_id = $ecom->id;               
			                                $app->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
			                                $app->identity_card = $result->ci;
			                                $app->last_name = $result->pat;
			                                $app->mothers_last_name = $result->mat;
			                                $app->first_name = $result->pnom;
			                                $app->second_name = $result->snom;
			                                $app->surname_husband = $result->apes;
			                                $app->birth_date = $result->fecha_nac;
			                                if ($result->ente_gestor == 'SENASIR') {
				                                $app->nua = 0;
			                                }else{
			                                	$app->nua = $result->nua_cua;
			                                }
			                                $app->civil_status = Util::getCivilStatus($result->eciv);
			                                $app->phone_number = $result->fijo;
			                                $app->cell_phone_number = $result->celular;
			                                $app->save();

			                                //adding spouse
		                                    $spouse = new Spouse();
		                                    $spouse->user_id = 1;
		                                    $spouse->affiliate_id = $afi->id;
		                                    $spouse->city_identity_card_id = Util::getRegionalCityExtId($result->ext);
		                                    $spouse->identity_card = $result->ci;                                
		                                    $spouse->registration = "0";
		                                    $spouse->last_name = $result->pat;
		                                    $spouse->mothers_last_name = $result->mat;
		                                    $spouse->first_name = $result->pnom;
		                                    $spouse->second_name = $result->snom;
		                                    $spouse->surname_husband = $result->apes;
		                                    $spouse->civil_status = Util::getCivilStatus($result->eciv);
		                                    $spouse->birth_date = $result->fecha_nac;
		                                    $spouse->save();
		                                
			                                //añadiendo requisitos
			                                $req = EconomicComplementRequirement::where('eco_com_type_id','=', 2 )->get();
			                                foreach ($req as $item) 
			                                {   
		                                        $submit = new EconomicComplementSubmittedDocument();
		                                        $submit->economic_complement_id = $ecom->id;
		                                        $submit->eco_com_requirement_id = $item->id;
		                                        $submit->reception_date =  Carbon::createFromDate(2017, 7, 7);
		                                        switch ($item->id) 
		                                        {
		                                        	
		                                        	case "6":
		                                        		$submit->status = ($result->iviu_boleta == 'SI');
		                                        		break;
		                                        	case "7":
		                                        		$submit->status = ($result->iviu_ci_causa == 'SI');
		                                        		break;
		                                        	case "8":
		                                        		$submit->status = ($result->iviu_ci_dere == 'SI');
		                                        		break;
		                                        	case "9":
		                                        		$submit->status = ($result->ivui_defuncion_causa == 'SI');
		                                        		break;
		                                        	case "10":
		                                        		$submit->status = ($result->ivui_senasir_afp == 'SI');
		                                        		break;
		                                        	case "11":
		                                        		$submit->status = ($result->iviu_memo == 'SI');
		                                        		break;
		                                        	case "12":
		                                        		$submit->status = ($result->iviu_anioserv == 'SI');
		                                        		break;
		                                        	case "13":
		                                        		$submit->status = ($result->iviu_sereci == 'SI');
		                                        		break;
		                                        	default:
	                                                    $submit->status = false;
	                                                    break;
		                                        }
		                                        $submit->save();
			                                }
		                            	
	                            	}
	                            }
	                            else
	                            {
	                            	$exviu[] = $ecom1;
	                            }
                            }
                    });
                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();

                $this->info("\n\nReport Update:\n
                ".sizeof($viha)." Vuidedad HABITUAL.\n
                ".sizeof($viin)." Vuidedad INCLUSION.\n
                ".sizeof($veha)." Vejez HABITUAL.\n
                ".sizeof($vein)." Vejez INCLUSION.\n
                ".sizeof($exvej)." Vejez Existentes.\n
                ".sizeof($exviu)." Viudedad Existentes.\n
                Execution time $execution_time [minutes].\n");
            }

        }
        else {
            $this->error('Incorrect password!');
            exit();
        }



    }
}
