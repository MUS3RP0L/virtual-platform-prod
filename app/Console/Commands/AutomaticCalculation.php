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


		    			$economic_complements=EconomicComplement::whereYear('year','=',$year)->where('semester','=',$semester)->get();
			    		$economic_complement_rent_temp = EconomicComplementRent::whereYear('year','=',$year)->where('semester','=',$semester)->get();	    								
		    						
			    		$base_wage_temp = BaseWage::whereYear('month_year','=',$year)->get();
			    		$count_all=0;
			    		if (sizeof($economic_complement_rent_temp)>0 && sizeof($base_wage_temp)>0 && sizeof($economic_complements)>0) 
			    		{
			    			
					    	foreach ($economic_complements as $economic_complement)
					    	{
					    		$Progress->advance();
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
						                    if ($comp == 1 && $economic_complement->total_rent >= 2000)
						                    {
						                        $economic_complement->eco_com_modality_id = 4;
						                    }
						                    elseif ($comp == 1 && $economic_complement->total_rent < 2000)
						                    {
						                        $economic_complement->eco_com_modality_id = 6;
						                    }
						                    elseif ($comp > 1 && $economic_complement->total_rent < 2000)
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
						                    if($comp == 1 && $economic_complement->total_rent >= 2000)
						                    {
						                        $economic_complement->eco_com_modality_id = 5;
						                    }
						                    elseif ($comp == 1 && $economic_complement->total_rent < 2000)
						                    {
						                        $economic_complement->eco_com_modality_id = 7;
						                    }
						                    elseif ($comp > 1 && $economic_complement->total_rent < 2000 )
						                    {
						                        $economic_complement->eco_com_modality_id = 9;
						                    }else{
						                        $economic_complement->eco_com_modality_id = 2;
						                    }
						                }
						                //orfandad
						                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 3)
						                {
						                    if ($comp == 1 && $economic_complement->total_rent >= 2000)
						                    {
						                        $economic_complement->eco_com_modality_id = 10;
						                    }
						                    elseif ($comp == 1 && $economic_complement->total_rent < 2000)
						                    {
						                        $economic_complement->eco_com_modality_id = 11;
						                    }
						                    elseif ($comp > 1 && $economic_complement->total_rent < 2000)
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
						                if($economic_complement->economic_complement_modality->economic_complement_type->id == 1 && $economic_complement->total_rent < 2000)
						                {
						                    //vejez
						                    $economic_complement->eco_com_modality_id = 8;
						                }
						                elseif ($economic_complement->economic_complement_modality->economic_complement_type->id == 2 && $economic_complement->total_rent < 2000)
						                {
						                    //Viudedad  
						                    $economic_complement->eco_com_modality_id = 9;
						                }
						                elseif($economic_complement->economic_complement_modality->economic_complement_type->id == 3 && $economic_complement->total_rent < 2000)
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

						    	    //para el promedio
						    	    if ($economic_complement->eco_com_modality_id > 3) 
						    	    {
						    	        $economic_complement_rent = EconomicComplementRent::where('degree_id','=',$economic_complement->affiliate->degree->id)
						    	            ->where('eco_com_type_id','=',$economic_complement->economic_complement_modality->economic_complement_type->id)
						    	            ->whereYear('year','=',Carbon::parse($economic_complement->year)->year)
						    	            ->where('semester','=',$economic_complement->semester)
						    	            ->first();
						    	        $total_rent=$economic_complement_rent->average;
						    	        $economic_complement->total_rent_calc = $economic_complement_rent->average;

						    	    }
						    	    $base_wage = BaseWage::degreeIs($economic_complement->affiliate->degree_id)->whereYear('month_year','=',Carbon::parse($economic_complement->year)->year)->first();
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
							    	$economic_complement->total=$total;
							    	$economic_complement->base_wage_id = $base_wage->id;
							    	$economic_complement->salary_reference=$salary_reference;
							    	$economic_complement->state = 'Edited';
							    	$economic_complement->save();
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