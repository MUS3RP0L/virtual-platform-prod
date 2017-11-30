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

class CopyAverage extends Command implements SelfHandling
{
    protected $signature = 'copy:average';
    protected $description = 'Copy average from last list average';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
                $year = $this->ask('Enter the year');
                $semester = $this->ask('Enter the semester');

                if($year > 0 and $semester != null)
                {   $time_start = microtime(true);
                    $this->info("Working...\n");
                    $Progress = $this->output->createProgressBar();
                    $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                    $Progress->advance();

                    $average_last = EconomicComplementRent::whereYear('eco_com_rents.year','=',$year)
                                                           ->where('eco_com_rents.semester','=', 'Primer')
                                                           ->orderBy('eco_com_rents.degree_id','ASC')->get();
                   
                        $cont1 = 0;
                        $cont2 = 0;

                        foreach($average_last as $item) 
                        {
                                    $avg_now = EconomicComplementRent::whereYear('eco_com_rents.year','=',$year)
                                                           ->where('eco_com_rents.semester','=', $semester)
                                                           ->where('eco_com_rents.degree_id','=', $item->degree_id)
                                                           ->where('eco_com_rents.eco_com_type_id','=', $item->eco_com_type_id)
                                                           ->first();                                    
                                   //Log::info($avg_now);
                                    if($avg_now) 
                                    {
                                        $avg_now->user_id = 1;
                                        $avg_now->degree_id = $avg_now->degree_id;
                                        $avg_now->eco_com_type_id = $avg_now->eco_com_type_id;
                                        $newdate = Carbon::createFromDate($year, 1, 1)->toDateString();
                                        $avg_now->year = $newdate;
                                        $avg_now->semester = $semester;
                                        $avg_now->minor = $item->minor;
                                        $avg_now->higher = $item->higher;
                                        $avg_now->average = $item->average;
                                        $avg_now->save();
                                        $cont1++;
                                    }
                                    else{                                        

                                        $rent = new EconomicComplementRent;
                                        $rent->user_id = 1;
                                        $rent->degree_id = $item->degree_id;
                                        $rent->eco_com_type_id = $item->eco_com_type_id;
                                        $newdate = Carbon::createFromDate($year, 1, 1)->toDateString();
                                        $rent->year = $newdate;
                                        $rent->semester = $semester;
                                        $rent->minor = $item->minor;
                                        $rent->higher = $item->higher;
                                        $rent->average = $item->average;
                                        $rent->save();
                                        $cont2++;
                                    }
                        }
                    

                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                    $Progress->finish();

                    $this->info("\n\nUpdate: $cont1\n
                        Created: $cont2\n
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
