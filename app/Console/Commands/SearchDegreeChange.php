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
use stdClass;


class SearchDegreeChange extends Command implements SelfHandling
{
    protected $signature = 'search:degree_change';
    protected $description = 'Busca los tramites que cambiaron de grado de la gestion 2016';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {   global $Progress, $aficount,$afincount, $d_ch_count, $d_n_ch_count,$c_ch_count, $c_n_ch_count, $nt, $degree, $category, $data ,$afi,$eco_new;
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
                            global $Progress,$aficount, $afincount, $d_ch_count, $d_n_ch_count,$c_ch_count, $c_n_ch_count, $nt, $degree, $category,$data,$afi,$eco_new;
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
                            $ci = $result->ci;
                            $app=EconomicComplementApplicant::where('identity_card','=',$ci)->first();
                            if ($app) {
                                $aficount++;
                                $eco_new=$app->economic_complement->affiliate->economic_complements()->where('eco_com_procedure_id','=',2)->first();
                                if ($eco_new) {
                                    $afi=$eco_new->affiliate;
                                    if ($result->grado <> $eco_new->degree->shortened) {
                                        $d_ch_count++;
                                        $data = new stdClass;
                                        $data->ci = $afi->identity_card;
                                        $data->ext = $afi->city_identity_card->first_shortened ?? '';
                                        $data->name = $afi->getFullName();
                                        $data->old_degree = $result->grado;
                                        $data->new_degree = $eco_new->degree->shortened ?? '';
                                        $degree[] = $data;
                                    }else{
                                        $d_n_ch_count++;
                                    }
                                    if ($result->categoria <> $eco_new->category->percentage) {                           
                                        $c_ch_count++;
                                        $data = new stdClass;
                                        $data->ci = $afi->identity_card;
                                        $data->ext = $afi->city_identity_card->first_shortened ?? '';
                                        $data->name = $afi->getFullName();
                                        $data->old_category = $result->categoria;
                                        $data->new_category = $eco_new->category->name??'';
                                        $category[] = $data;
                                    }else{
                                        $c_n_ch_count++;
                                    }
                                }else{
                                    $nt++;
                                Log::info($ci);
                                }
                            }else{
                                $afincount++;
                            }
                            $Progress->advance();
                    });
                });
                Excel::create('Lista Afiliados que se cambio el Grado y categoria'.date("Y-m-d H:i:s"),function($excel)
                {
                    global $degree,$category, $i;
                    $excel->sheet('Grado',function($sheet){
                    global $degree, $i;
                    $i=1;
                        $sheet->row($i, array('CI', 'EXT','NOMBRE','GRADO ANTIGUO','NUEVO GRADO'));
                        $i++;
                        foreach ($degree as $value) {
                            $sheet->row($i,   array($value->ci, $value->ext,$value->name,$value->old_degree,$value->new_degree));
                            $i++;
                        }
                    });
                    $excel->sheet('Categoria',function($sheet){
                    global $category,$i;
                    $i=1;
                        $sheet->setColumnFormat(array(
                            'D' => '0%'
                        ));
                        $sheet->row($i, array('CI', 'EXT','NOMBRE','CATEGORIA ANTIGUA','NUEVO CATEGORIA'));
                        $i++;
                        foreach ($category as $value) {
                            $sheet->row($i, array($value->ci, $value->ext,$value->name,$value->old_category,$value->new_category));
                            $i++;
                        }
                    });
                })->store('xls', storage_path('excel/exports'));
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\nFound $aficount Affiliates\n
                    \tTotal que cambiaron Grado $d_ch_count\n
                    \tTotal que NO cambiaron Grado $d_n_ch_count\n
                    \tTotal que cambiaron Categoria $c_ch_count\n
                    \tTotal que NO cambiaron Categoria $c_n_ch_count\n
                    Afiliados sin tramites en el 2017: $nt\n
                    Not Found $afincount affiliates\n
                Execution time $execution_time [minutes].\n");
            }
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
