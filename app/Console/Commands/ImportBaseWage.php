<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\BaseWage;
use Muserpol\Hierarchy;
use Muserpol\Degree;

class ImportBaseWage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:basewage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Base Wages provided by General Command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $results, $base_wages, $Progress, $FolderName, $Date;

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

                        global $results, $base_wages, $Progress, $FolderName, $Date;

                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');

                        $Date = Util::zero($result->mes) . "-" . Util::formatYear($result->a_o);

                        // $results = collect($result->select(array('mes', 'a_o', 'niv', 'gra','sue'))->get());

                    });

                });

                $year = Carbon::parse($Date)->year;
                $newyear = substr($year, -2, 2);
                $month = Carbon::parse($date)->month;

                // $degrees = Degree::orderBy('id', 'asc')->get();
                // foreach ($degrees as $degree) {

                //     foreach ($results as $datos) {
                //         if($month ==  (int) $datos['mes'] && $newyear == rtrim($datos['a_o'])){                    
                //             if($degree->hierarchy->code == $datos['niv']  && $degree->code == $datos['gra'] && Util::decimal(Util::zero($datos['sue'])) > 0 ) {
                //                 $base_wages .= $degree->hierarchy->code . " " . $degree->code . " - " . Util::decimal(Util::zero($datos['sue'])) ."\r\n";
                //                 $base_wage =  BaseWage::where('degree_id', '=', $degree->id)
                //                                 ->whereDate('month_year', '=', Util::datePickPeriod($request->month_year))->first();
                //                 if(!$base_wage) {
                //                     $base_wage = new BaseWage;
                //                     $base_wage->user_id = Auth::user()->id;
                //                     $base_wage->degree_id = $degree->id;
                //                     $base_wage->month_year = $date;
                //                     $base_wage->amount = Util::decimal($datos['sue']);
                //                     $base_wage->save();
                //                 }
                //             }
                //         }
                //     }
                // }

                // $this->info("\n\nReport $Date:\n
                //         $base_wages");

                \Storage::disk('local')->put('BaseWage'. $date.'.txt', 
                    "Reporte de Importacion de Sueldo Básico:\r\n$base_wages");
            }
        }
        else{
            $this->error('Incorrect password!');
            exit();
        }
    }
}
