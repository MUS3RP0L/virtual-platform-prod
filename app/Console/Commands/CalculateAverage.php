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

                /*todo add search procwedure */
                if($year > 0 and $semester != null)
                {   $time_start = microtime(true);
                    $this->info("Working...\n");
                    $Progress = $this->output->createProgressBar();
                    $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                    $Progress->advance();

                    
                    $eco_com_rents = EconomicComplementRent::whereYear("year", '=',$year)->where('semester', $semester)->get();
                    foreach ($eco_com_rents as $value) {
                        $value->delete();
                    }
                    $average_list = DB::table('eco_com_applicants')
                                    ->select(DB::raw("affiliates.degree_id as degree_id,economic_complements.eco_com_modality_id,min(economic_complements.total_rent) as rmin, max(economic_complements.total_rent) as rmax,round((max(economic_complements.total_rent)+ min(economic_complements.total_rent))/2,2) as average"))
                                    ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                    ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                    ->leftJoin('eco_com_procedures','economic_complements.eco_com_procedure_id','=','eco_com_procedures.id')
                                    ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                    ->leftJoin('base_wages','economic_complements.degree_id','=','base_wages.degree_id')
                                    ->where('economic_complements.eco_com_procedure_id', '=', 13)
                                    ->whereYear('base_wages.month_year', '=', $year)
                                    ->whereRaw("economic_complements.total_rent::numeric >= eco_com_procedures.indicator::numeric")
                                    //->whereRaw('economic_complements.total_rent::numeric <= base_wages.amount::numeric') //MAL                                   
                                    ->whereIN('economic_complements.eco_com_modality_id',[1,2])
                                    ->where(function ($query)
                                    {
                                        $query->whereNull('economic_complements.aps_disability')
                                        ->orWhere('economic_complements.aps_disability', '=','0');
                                     })
                                    ->groupBy('affiliates.degree_id','economic_complements.eco_com_modality_id')
                                    ->orderBy('affiliates.degree_id','ASC')->get();
//                    dd($average_list);
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
