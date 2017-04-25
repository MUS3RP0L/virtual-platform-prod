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
        global $results, $FileName;

        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FileName = $this->ask('Enter the name of the file you want to import');

            if ($this->confirm('Are you sure to import the file "' . $FileName . '" ? [y|N]') && $FileName) {

                $this->info("Working...\n");

                Excel::load('public/file_to_import/' . $FileName . '.xlsx', function($result) {

                    global $results, $FileName;

                    ini_set('memory_limit', '-1');
                    ini_set('max_execution_time', '-1');
                    ini_set('max_input_time', '-1');
                    set_time_limit('-1');

                    $results = collect($result->select(array('mes', 'a_o', 'niv', 'gra','sue'))->get());

                });

                $degrees = Degree::orderBy('id', 'asc')->get();
                $base_wages=' ';
                
                foreach ($degrees as $degree) {
                    foreach ($results as $result) {
                        if($degree->hierarchy->code == $result['niv']  && $degree->code == $result['gra'] && Util::decimal(Util::zero($result['sue'])) > 0 ) {
                            $month_year = Carbon::createFromDate(Util::formatYear($result['a_o']), Util::zero($result['mes']), 1)->toDateString();
                            $base_wage =  BaseWage::where('degree_id', '=', $degree->id)
                                            ->whereDate('month_year', '=', $month_year)->first();
                            if(!$base_wage) {

                                $base_wages .= $degree->hierarchy->code . " " . $degree->code . " - " . Util::decimal(Util::zero($result['sue'])) ."\r\n";

                                $base_wage = new BaseWage;
                                $base_wage->user_id = 1;
                                $base_wage->degree_id = $degree->id;
                                $base_wage->month_year = $month_year;
                                $base_wage->amount = Util::decimal($result['sue']);
                                $base_wage->save();
                            }
                        }      
                    }
                }

                $this->info("\n\nReport results:\n
                        $base_wages");

                \Storage::disk('local')->put('BaseWage'. $month_year.'.txt', 
                    "Reporte de Importacion de Sueldo Básico:\r\n$base_wages");
            }
        }
        else{
            $this->error('Incorrect password!');
            exit();
        }
    }
}
