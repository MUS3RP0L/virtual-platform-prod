<?php
namespace Muserpol\Console\Commands;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;
use Log;
use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;
use stdClass;

class ImportAvailabilityDate extends Command implements SelfHandling
{
    protected $signature = 'import:availability_date';   
    protected $description = 'Importacion De las fechas de disponibilidad';

    public function handle()
    {
    	global $Progress, $count, $afino, $afiecono, $afisuc, $matchessuc_disp, $matchesno_disp,$matchessuc_memo, $matchesno_memo,$data, $row,$data_no, $row_no, $dispo,$memo;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            $FolderName = $this->ask('Enter the name of the folder you want to import');
            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();                
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                $row=array();
                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {
                    $rows->each(function($result) {
                        global $Progress, $count, $afino, $afiecono, $afisuc,$matchessuc_disp, $matchesno_disp,$matchessuc_memo, $matchesno_memo, $data,$row,$data_no,$row_no, $dispo,$memo;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $Progress->advance();
                        $ci = trim($result->ci).($result->ext ? '-'.$result->ext: '' );
                        $afi = Affiliate::where('identity_card','=',$ci)->first();
                        if ($afi) {
                            $re = '(\d{1,2}(| )\/\d{1,2}\/\d{2,4}|\d{1,2}\/\d{4})';
                                    // $re = '/\d{1,2}(| )\/\d{1,2}\/\d{2,4}/';
                            $str = $result->disp;
                            preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
                            if ($matches) {
                                $this->info($matches[0][0]);
                                $dispo = $matches[0][0];
                                $matchessuc_disp++;
                            }else{
                                $this->info($afi->identity_card);
                                $dispo = '';
                                $matchesno_disp++;
                            }
                            $re = '(\d{1,2}(| )\/\d{1,2}\/\d{2,4}|\d{1,2}\/\d{4})';
                                    // $re = '/\d{1,2}(| )\/\d{1,2}\/\d{2,4}/';
                            $str = $result->memo;
                            preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);
                            if ($matches) {
                                $memo = $this->info($matches[0][0]);
                                $memo = $matches[0][0];
                                $matchessuc_memo++;
                            }else{
                                $memo = '';
                                $this->info($afi->identity_card);
                                $matchesno_memo++;
                            }
                            $data = new stdClass;
                            $data->ci = $result->ci;
                            $data->name = $result->nombre;
                            $data->dispo = $dispo;
                            $data->memo = $memo;
                            $data->ext = $result->ext;
                            $row[] = $data;
                            $afisuc[]=$ci;  
                        }else{
                            $afino[]=$ci;
                            $data_no = new stdClass;
                            $data_no->ci = $result->ci;
                            $data_no->ext = $result->ext;
                            $data_no->name = $result->nombre;
                            $row_no[] = $data_no;
                        }
                    });
                });

                Excel::create('Lista Agradecidos y no Agradecidos '.date("Y-m-d H:i:s"),function($excel)
                {
                    global $row,$row_no, $i;
                    $excel->sheet('Lista Agradecidos',function($sheet){
                    global $row, $i;
                    $i=1;
                        $sheet->row($i, array('CI', 'EXT','NOMBRE','DISPONIBILIDAD','MEMORANDUM'));
                        $i++;
                        foreach ($row as $value) {
                            $sheet->row($i,   array($value->ci, $value->ext,$value->name,$value->dispo,$value->memo));
                            $i++;
                        }
                    });
                    $excel->sheet('No Encotrados',function($sheet){
                    global $row_no,$i;
                    $i=1;
                        $sheet->row($i, array('CI', 'EXT','NOMBRE'));
                        $i++;
                        foreach ($row_no as $value) {
                            $sheet->row($i,   array($value->ci, $value->ext,$value->name));
                            $i++;
                        }
                    });

                })->store('xls', storage_path('excel/exports'));

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();

                $this->info("\n\nReport Update:\n
                Total encontrados ".sizeof($afisuc)." \n
                Disp
                \t Match successfull ".$matchessuc_disp."\n
                \t Match not found ".$matchesno_disp."\n
                Memos
                \t Match successfull ".$matchessuc_memo."\n
                \t Match not found ".$matchesno_memo."\n
                Afiliados no econtrados ".sizeof($afino).". \n                
                Execution time $execution_time [minutes].\n");
                Log::info('Successful');
                Log::info($afisuc);
                Log::info('No encontrado ');
                Log::info($afino);
                Log::info('sin tramites ');
                Log::info($afiecono);
            }
        }
        else {
            $this->error('Incorrect password!');
            exit();
        }
    }
}

