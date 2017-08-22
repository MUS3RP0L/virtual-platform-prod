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
    {   global $Progress, $aficount,$afincount, $d_ch_count, $d_n_ch_count,$c_ch_count, $c_n_ch_count, $nt, $degree, $category, $data ,$data_may ,$afi,$eco_new,$degree_may,$category_men;
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
                            global $Progress,$aficount, $afincount, $d_ch_count, $d_n_ch_count,$c_ch_count, $c_n_ch_count, $nt, $degree, $category,$data,$data_may,$afi,$eco_new,$degree_may,$category_men;
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
                                        $data->name = $afi->getFullNameChange();
                                        $data->old_degree = $result->grado;
                                        $data->new_degree = $eco_new->degree->shortened ?? '';
                                        $data->type = $eco_new->economic_complement_modality->economic_complement_type->name;
                                        $degree[] = $data;
                                        if ($result->complemento_final > $eco_new->total) {
                                            $data_may = new stdClass;
                                            $data_may->ci = $afi->identity_card;
                                            $data_may->ext = $afi->city_identity_card->first_shortened ?? '';
                                            $data_may->name = $afi->getFullNameChange();
                                            $data_may->old_degree = $result->grado;
                                            $data_may->new_degree = $eco_new->degree->shortened ?? '';
                                            $data_may->type = $eco_new->economic_complement_modality->economic_complement_type->name;
                                            $data_may->eco_old = $result->complemento_final;
                                            $data_may->eco_new = $eco_new->total;
                                            $degree_may[] = $data_may;
                                        }
                                    }else{
                                        $d_n_ch_count++;
                                    }
                                    if ($result->categoria <> $eco_new->category->percentage) {                           
                                        $c_ch_count++;
                                        $data = new stdClass;
                                        $data->ci = $afi->identity_card;
                                        $data->ext = $afi->city_identity_card->first_shortened ?? '';
                                        $data->name = $afi->getFullNameChange();
                                        $data->old_category = $result->categoria;
                                        $data->new_category = $eco_new->category->name??'';
                                        $category[] = $data;
                                        if ($result->categoria > $eco_new->category->percentage) {
                                            $data_men = new stdClass;
                                            $data_men->ci = $afi->identity_card;
                                            $data_men->ext = $afi->city_identity_card->first_shortened ?? '';
                                            $data_men->name = $afi->getFullNameChange();
                                            $data_men->old_category = $result->categoria;
                                            $data_men->new_category = $eco_new->category->name??'';
                                            $data_men->eco_old = $result->complemento_final;
                                            $data_men->eco_new = $eco_new->total;
                                            $category_men[] = $data_men;
                                        }
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
                        $sheet->row($i, array('CI', 'EXT','NOMBRE','GRADO ANTIGUO','NUEVO GRADO','TIPO'));
                        $i++;
                        foreach ($degree as $value) {
                            $sheet->row($i,   array($value->ci, $value->ext,$value->name,$value->old_degree,$value->new_degree,$value->type));
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
                    $excel->sheet('Grado Mayor',function($sheet){
                        global $degree_may,$i;
                        $i=1;
                        $sheet->row($i, array('CI', 'EXT','NOMBRE','GRADO ANTIGUO','NUEVO GRADO','TIPO','COMPLEMENTO 2016','COMPLEMENTO 2017'));
                        $i++;
                        foreach ($degree_may as $value) {
                            $sheet->row($i,   array($value->ci, $value->ext,$value->name,$value->old_degree,$value->new_degree,$value->type,$value->eco_old,$value->eco_new));
                            $i++;
                        }
                    });
                    $excel->sheet('Categoria Mayor',function($sheet){
                        global $category_men,$i;
                        $i=1;
                        $sheet->setColumnFormat(array(
                            'D' => '0%'
                        ));
                        $sheet->row($i, array('CI', 'EXT','NOMBRE','CATEGORIA ANTIGUA','NUEVO CATEGORIA','COMPLEMENTO 2016','COMPLEMENTO 2017'));
                        $i++;
                        foreach ($category_men as $value) {
                            $sheet->row($i, array($value->ci, $value->ext,$value->name,$value->old_category,$value->new_category,$value->eco_old,$value->eco_new));
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
