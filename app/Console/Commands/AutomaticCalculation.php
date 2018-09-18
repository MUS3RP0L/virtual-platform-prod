<?php
namespace Muserpol\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Muserpol\Degree;
use Muserpol\Affiliate;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\ComplementaryFactor;
use Muserpol\BaseWage;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementRent;
use Muserpol\EconomicComplementProcedure;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

class AutomaticCalculation extends Command implements SelfHandling
{
    protected $signature = 'calculate:complement';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   
    	global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
                $year = $this->ask('Enter the year');
                $semester = $this->ask('Enter the semester');
                if($year > 0 and $semester != null)
                {   $time_start = microtime(true);
                    $this->info("Working...\n");
                    $Progress = $this->output->createProgressBar();
                    $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");                   

                    	//$economic_complements=EconomicComplement::whereYear('year','=',$year)->where('semester','=',$semester)->where('total_rent','>',0)->get();
                    	$economic_complements=EconomicComplement::whereYear('year','=',$year)->where('semester','=',$semester)->where('total_rent','>',0)->whereNull('total')->get(); //original
                    	//$economic_complements=EconomicComplement::whereYear('year','=',$year)->where('semester','=',$semester)->where('workflow_id','=',3)->where('total_rent','>',0)->get();
		    			//$economic_complements=EconomicComplement::whereYear('year','=',$year)->where('semester','=',$semester)->get();  //original
			    		$economic_complement_rent_temp = EconomicComplementRent::whereYear('year','=',$year)->where('semester','=',$semester)->get();	
			    		$procedure = EconomicComplementProcedure::whereYear('year','=',$year)->where('semester','=',$semester)->first();
		    						
			    		$base_wage_temp = BaseWage::whereYear('month_year','=',$year)->get();
			    		$count_all=0;
			    		// dd($economic_complement_rent_temp->count(),($base_wage_temp->count()),($economic_complements->count()),$procedure->indicator);


			    		// comentar para mandar el oficial
			    		$eco_com_state_paid_bank = 24;

			    		if (sizeof($economic_complement_rent_temp)>0 && sizeof($base_wage_temp)>0 && sizeof($economic_complements)>0 && $procedure->indicator>0) 
			    		{
			    			
					    	foreach ($economic_complements as $economic_complement)
					    	{
					    		$Progress->advance();
					    		
					    		// comentar para mandar el oficial
					    		if ( $economic_complement->eco_com_state_id != $eco_com_state_paid_bank || is_null($economic_complement->total)) {
					    			
						    		if ($economic_complement->total_rent > 0) 
						    		{
						    			if($economic_complement->affiliate->pension_entity->type=='APS')  // Modality APS
						    			{
							                $comp=0;
							                if ($economic_complement->aps_total_fsa > 0) 
							                {
							                    $comp++;
							                }
							                if ($economic_complement->aps_total_cc > 0) 
							                {
							                    $comp++;
							                }
							                if ($economic_complement->aps_total_fs > 0) 
							                {
							                    $comp++;
							                }						               
							                //vejez
							                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 1)
							                {
							                    if ($comp == 1 && $economic_complement->total_rent >= $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 4;
							                    }
							                    elseif ($comp == 1 && $economic_complement->total_rent < $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 6;
							                    }
							                    elseif ($comp > 1 && $economic_complement->total_rent < $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 8;
							                    }
							                    else
							                    {
							                        $economic_complement->eco_com_modality_id = 1;
							                    }
							                }
							                //Viudedad
							                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 2)
							                {
							                    if($comp == 1 && $economic_complement->total_rent >= $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 5;
							                    }
							                    elseif ($comp == 1 && $economic_complement->total_rent < $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 7;
							                    }
							                    elseif ($comp > 1 && $economic_complement->total_rent < $procedure->indicator )
							                    {
							                        $economic_complement->eco_com_modality_id = 9;
							                    }else{
							                        $economic_complement->eco_com_modality_id = 2;
							                    }
							                }
							                //orfandad
							                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 3)
							                {
							                    if ($comp == 1 && $economic_complement->total_rent >= $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 10;
							                    }
							                    elseif ($comp == 1 && $economic_complement->total_rent < $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 11;
							                    }
							                    elseif ($comp > 1 && $economic_complement->total_rent < $procedure->indicator)
							                    {
							                        $economic_complement->eco_com_modality_id = 12;
							                    }
							                    else
							                    {
							                        $economic_complement->eco_com_modality_id = 3;
							                    }
							                }
							            }
							            else // Modality SENASIR
							            {						            	
							                if($economic_complement->economic_complement_modality->economic_complement_type->id == 1 && $economic_complement->total_rent < $procedure->indicator)
							                {
							                    //vejez
							                    $economic_complement->eco_com_modality_id = 8;
							                }
							                elseif ($economic_complement->economic_complement_modality->economic_complement_type->id == 2 && $economic_complement->total_rent < $procedure->indicator)
							                {
							                    //Viudedad  
							                    $economic_complement->eco_com_modality_id = 9;
							                }
							                elseif($economic_complement->economic_complement_modality->economic_complement_type->id == 3 && $economic_complement->total_rent < $procedure->indicator)
							                {   //Orfandad 
							                    $economic_complement->eco_com_modality_id = 12;
							                }
							                else 
							                {
							                    $economic_complement->eco_com_modality_id = $economic_complement->economic_complement_modality->economic_complement_type->id;
							                }
							            }
							            $economic_complement->save(); // Saving Modalities

						    			$count_all++;
							    	    $economic_complement->total_rent_calc = $economic_complement->total_rent;
							    	    $total_rent = $economic_complement->total_rent;

							    	    //CALCULATE WITH AVERAGE FOR MODALITIES 
							    	    if ($economic_complement->eco_com_modality_id > 3 && ($economic_complement->eco_com_modality_id <10 )) 
							    	    {
							    	    	$this->info($economic_complement);
							    	    	$this->info("-----");
							    	        $economic_complement_rent = EconomicComplementRent::where('degree_id','=',$economic_complement->degree_id)
							    	            ->where('eco_com_type_id','=',$economic_complement->economic_complement_modality->economic_complement_type->id)
							    	            ->whereYear('year','=',Carbon::parse($economic_complement->year)->year)
							    	            ->where('semester','=',$economic_complement->semester)
							    	            ->first();

							    	        // EXCEPTION WHEN TOTAL_RENT > AVERAGE IN MODALITIES 4 AND 5
							    	        if($economic_complement->total_rent > $economic_complement_rent->average and ($economic_complement->eco_com_modality_id == 4 || $economic_complement->eco_com_modality_id == 5 || $economic_complement->eco_com_modality_id == 10))
							    	        {
							    	        	$total_rent = $economic_complement->total_rent;
							    	        	$economic_complement->total_rent_calc = $economic_complement->total_rent;
							    	        }
							    	        else
							    	        {
							    	        	$total_rent=$economic_complement_rent->average;
							    	        	$economic_complement->total_rent_calc = $economic_complement_rent->average;
							    	        }
							    	        

							    	    }
							    	    else if( $economic_complement->eco_com_modality_id >= 10 )
							    	    {
									            $economic_complement_rent = EconomicComplementRent::where('degree_id','=',$economic_complement->degree_id)
									                                        ->where('eco_com_type_id','=',1)
									                                        ->whereYear('year','=',Carbon::parse($economic_complement->year)->year)
									                                        ->where('semester','=',$economic_complement->semester)
									                                        ->first();

									            if($economic_complement->total_rent > $economic_complement_rent->average and $economic_complement->eco_com_modality_id == 10)
									            {
									            	$total_rent = $economic_complement->total_rent;
									            	$economic_complement->total_rent_calc = $economic_complement->total_rent;
									            }
									            else
									            {
									            	$total_rent=$economic_complement_rent->average;
									            	$economic_complement->total_rent_calc = $economic_complement_rent->average;
									            }
									    }
							    	    $base_wage = BaseWage::degreeIs($economic_complement->degree_id)->whereYear('month_year','=',Carbon::parse($economic_complement->year)->year)->first();

							    	    //PARA EL CASO DE VIUDAS TOMAR EL 80% DEL SALARIO REFERENCIAL
							    	    if ($economic_complement->economic_complement_modality->economic_complement_type->id==2) 
							    	    {
							    	        $base_wage_amount=$base_wage->amount*(80/100);
							    	        $salary_reference = $base_wage_amount;
							    	        $seniority = $economic_complement->category->percentage * $base_wage_amount;
							    	    }
							    	    else
							    	    {
							    	        $salary_reference = $base_wage->amount;
							    	        $seniority = $economic_complement->category->percentage * $base_wage->amount;
							    	    }
							    	   
							    	    $economic_complement->seniority=$seniority;
							    	    $salary_quotable = $salary_reference + $seniority;
							    	    $economic_complement->salary_quotable=$salary_quotable;
							    	    $difference = $salary_quotable - $total_rent;
							    	    $economic_complement->difference=$difference;
							    	    $months_of_payment = 6;
							    	    $total_amount_semester = $difference * $months_of_payment;
							    	    $economic_complement->total_amount_semester=$total_amount_semester;
								    	$complementary_factor = ComplementaryFactor::hierarchyIs($base_wage->degree->hierarchy->id)
								    	                            ->whereYear('year', '=', Carbon::parse($economic_complement->year)->year)
								    	                            ->where('semester', '=', $economic_complement->semester)->first();
								    	$economic_complement->complementary_factor_id = $complementary_factor->id;
								    	if ($economic_complement->economic_complement_modality->eco_com_type_id == 2 ) 
								    	{   //viudedad
								    	    $complementary_factor=$complementary_factor->widowhood;
								    	}
								    	else
								    	{   //vejez
								    	    $complementary_factor=$complementary_factor->old_age;
								    	}
								    	$economic_complement->complementary_factor=$complementary_factor;
								    	$total = $total_amount_semester * floatval($complementary_factor)/100;

								    	//RESTANDO PRESTAMOS, CONTABILIDAD Y REPOSICION AL TOTAL PORCONCEPTO DE DEUDA
								    	if($economic_complement->amount_loan > 0)
								    	{
								    		$total  = $total - $economic_complement->amount_loan;
								    	}
								    	if($economic_complement->amount_accounting > 0)
								    	{
								    		$total  = $total - $economic_complement->amount_accounting;
								    	}
								    	if($economic_complement->amount_replacement > 0)
								    	{
								    		$total  = $total - $economic_complement->amount_replacement;
								    	}

								    	$economic_complement->total=$total;
								    	$economic_complement->base_wage_id = $base_wage->id;
								    	$economic_complement->salary_reference=$salary_reference;
								    	$economic_complement->calculation_date = Carbon::now();

								    	$economic_complement->save();
						    		}
					    		}
					    	}
			    		}
			    		else
			    		{
							$this->info("Virificar si existen Promedios, Sueldos y Factor de complemento\n");
				    	}
		             $time_end = microtime(true);
		             $execution_time = ($time_end - $time_start)/60;
		             $Progress->finish();

		             $this->info("\n\nActualizados:\n
		             ".$count_all." .\n");
		             $this->info("\n\nReport Calculate average:\n
		             Execution time $execution_time [minutes].\n");
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