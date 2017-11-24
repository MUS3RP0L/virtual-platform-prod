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

class CalculateAverage extends Command implements SelfHandling
{
    protected $signature = 'import:average';
    protected $description = 'Command description';

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

                    $average_list = DB::table('eco_com_applicants')
                                    ->select(DB::raw("affiliates.degree_id as degree_id,economic_complements.eco_com_modality_id,min(economic_complements.total_rent) as rmin, max(economic_complements.total_rent) as rmax,round((max(economic_complements.total_rent)+ min(economic_complements.total_rent))/2,2) as average"))
                                    ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                    ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                    ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                    ->whereYear('economic_complements.year', '=', $year)
                                    ->where('economic_complements.semester', '=', $semester)
                                    ->where('economic_complements.total_rent','>', 0)
                                    ->whereIN('economic_complements.eco_com_modality_id',[1,2])
                                    ->whereRaw('economic_complements.total_rent::numeric < economic_complements.salary_quotable::numeric')
                                    ->whereNull('economic_complements.aps_disability')
                                    ->groupBy('affiliates.degree_id','economic_complements.eco_com_modality_id')
                                    ->orderBy('affiliates.degree_id','ASC')->get();
                    
                    if($average_list)
                    {
                        foreach($average_list as $item) {
                                    $rent = EconomicComplementRent::where('degree_id','=', $item->degree_id)
                                                                ->where('eco_com_type_id','=', $item->eco_com_modality_id)
                                                                ->whereYear('year','=', $year)
                                                   ->where('semester', '=', $semester)->first();
                                                   $date = Carbon::now();
                                    if(!$rent) {
                                        
                                        $rent = new EconomicComplementRent;
                                        $rent->user_id = 1;
                                        $rent->degree_id = $item->degree_id;
                                        $rent->eco_com_type_id = $item->eco_com_modality_id;
                                        $newdate = Carbon::createFromDate($year, 1, 1)->toDateString();
                                        $rent->year = $newdate;
                                        $rent->semester = $semester;
                                        $rent->minor = $item->rmin;
                                        $rent->higher = $item->rmax;
                                        $rent->average = $item->average;
                                        $rent->save();
                                    }
                                    else{
                                        $rent->user_id = 1;
                                        $rent->degree_id = $item->degree_id;
                                        $rent->eco_com_type_id = $item->eco_com_modality_id;
                                        $newdate = Carbon::createFromDate($year, 1, 1)->toDateString();
                                        $rent->year = $newdate;
                                        $rent->semester = $semester;
                                        $rent->minor = $item->rmin;
                                        $rent->higher = $item->rmax;
                                        $rent->average = $item->average;
                                        $rent->save();
                                    }
                        }
                    }

                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                    $Progress->finish();

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
