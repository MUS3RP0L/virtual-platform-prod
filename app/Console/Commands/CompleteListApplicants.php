<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Log;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;
use Muserpol\Affiliate;
use stdClass;
use Muserpol\Spouse;

class CompleteListApplicants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:applicants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $Progress, $new_rows, $afisi, $afino, $afispouseno,  $spousesi, $spouseno;
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
                        global $Progress, $new_rows, $afisi, $afino, $afispouseno,  $spousesi, $spouseno;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $c_p_nombre = $result->p_nombre_c;
                        $c_s_nombre = $result->s_nombre_c;
                        $c_pat = $result->paterno_c;
                        $c_mat = $result->materno_c;
                        $d_p_nombre = $result->p_nombre_d;
                        $d_s_nombre = $result->s_nombre_d;
                        $d_pat = $result->paterno_d;
                        $d_mat = $result->materno_d;
                        // if (strtolower($c_p_nombre) == 'ricardo') {
                        //     $this->info($c_p_nombre);
                        // }
                        if (isset($c_p_nombre) || isset($c_s_nombre) || isset($c_pat) || isset($c_mat))
                        {
                            $affiliate = Affiliate::whereRaw("coalesce(affiliates.first_name, '') like '".Util::removeSpaces(strtoupper($c_p_nombre))."%'")
                                    ->whereRaw("coalesce(affiliates.second_name, '') like '".Util::removeSpaces(strtoupper($c_s_nombre))."%'")
                                    ->whereRaw("coalesce(affiliates.last_name, '') like '".Util::removeSpaces(strtoupper($c_pat))."%'")
                                    ->whereRaw("coalesce(affiliates.mothers_last_name, '') like '".Util::removeSpaces(strtoupper($c_mat))."%'")
                                    ->first()
                                    ;
                            // Log::info($affiliate);
                            if ($affiliate) {
                                $afisi++;
                                $spouse = $affiliate->spouse;
                                if ($spouse) {
                                    $new_rows[] = array(
                                        'ci_c' => $affiliate->identity_card,
                                        'p_nombre_c' => $result->p_nombre_c,
                                        's_nombre_c' => $result->s_nombre_c,
                                        'paterno_c' => $result->paterno_c,
                                        'materno_c' => $result->materno_c,
                                        'ci_d' => $spouse->identity_card,
                                        'p_nombre_d' => $spouse->first_name,
                                        's_nombre_d' => $spouse->second_name,
                                        'paterno_d' => $spouse->last_name,
                                        'materno_d' => $spouse->mothers_last_name,
                                    );
                                    // $new_rows[] = $data_spouse;
                                }else{
                                    $afispouseno++;
                                }
                            }else{
                                $afino++;
                            }
                        }else{
                            if (isset($d_p_nombre)||isset($d_s_nombre)||isset($d_pat)||isset($d_mat))
                            {
                                $spouse = Spouse::whereRaw("coalesce(spouses.first_name, '') like '" . Util::removeSpaces(strtoupper($d_p_nombre)) . "%'")
                                    ->whereRaw("coalesce(spouses.second_name, '') like '" . Util::removeSpaces(strtoupper($d_s_nombre)) . "%'")
                                    ->whereRaw("coalesce(spouses.last_name, '') like '" . Util::removeSpaces(strtoupper($d_pat)) . "%'")
                                    ->whereRaw("coalesce(spouses.mothers_last_name, '') like '" . Util::removeSpaces(strtoupper($d_mat)) . "%'")
                                    ->first();
                                if ($spouse) {
                                    $spousesi++;
                                    $affiliate = $spouse->affiliate;
                                    if ($affiliate) {
                                        $new_rows[] = array(
                                            'ci_c' => $affiliate->identity_card,
                                            'p_nombre_c' => $affiliate->first_name,
                                            's_nombre_c' => $affiliate->second_name,
                                            'paterno_c' => $affiliate->last_name,
                                            'materno_c' => $affiliate->mothers_last_name,
                                            'ci_d' => $spouse->identity_card,
                                            'p_nombre_d' => $spouse->first_name,
                                            's_nombre_d' => $spouse->second_name,
                                            'paterno_d' => $spouse->last_name,
                                            'materno_d' => $spouse->mothers_last_name,
                                        );
                                    // $new_rows[] = $data_spouse;
                                    } else {
                                    }
                                } else {
                                    $spouseno++;
                                }
                            }
                        }
                        $Progress->advance(); 
                    });
                });
                Excel::create('Lista de derechohabientes y causahabientes completada' . date("Y-m-d H:i:s"), function ($excel) {
                    global $new_rows;
                    $excel->sheet('lista', function ($sheet) use ($new_rows) {
                        global $new_rows;
                        $sheet->fromArray($new_rows);
                    });
                })->store('xls', storage_path('excel/exports'));
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\n Afiliados encontrados: $afisi\n
                Afiliados NO encontradosL: $afino\n
                Esposas no econtrados (pero si el afiliado): $afispouseno\n
                \n ---------------------\n
                Viudas encontrdaas: $spousesi \n
                Viudas NO encontrdaas: $spouseno \n
                Execution time $execution_time [minutes].\n");
            }
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
