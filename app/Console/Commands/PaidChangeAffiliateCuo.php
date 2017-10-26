<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use DB;

class PaidChangeAffiliateCuo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:paid_affiliate_cuo';

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
        
        
        global $Progress, $aficount,$afincount, $affiliate_no,$affiliate_yes, $d_ch_count, $d_n_ch_count,$c_ch_count, $c_n_ch_count, $nt, $degree, $category, $data ,$data_may ,$afi,$eco_new,$degree_may,$category_men;
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
                        global $Progress,$aficount, $afincount, $affiliate_no,$affiliate_yes, $d_ch_count, $d_n_ch_count,$c_ch_count, $c_n_ch_count, $nt, $degree, $category,$data,$data_may,$afi,$eco_new,$degree_may,$category_men;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $n = explode('-', $result->razon)[0];
                        $name = str_replace("?","Ñ",trim(strtoupper(Util::removeSpaces($n))));
                        $aff=Affiliate::whereRaw("upper(trim(regexp_replace(CONCAT(affiliates.first_name,' ',affiliates.second_name,' ',affiliates.last_name,' ',affiliates.mothers_last_name,' ',affiliates.surname_husband),'( )+' , ' ', 'g'))) like '".$name."'")->first();
                        if ($aff) {
                            $aficount++;
                            $affiliate_yes[]= array(
                                'nombre'=>$n,
                                'razon'=>$result->razon,
                                'anio'=>$result->anio,
                            );
                            $exists=DB::table('paid_affiliates')->where('type','=','C')->where('affiliate_id', '=', $aff->id)->first();
                            if (!$exists) {
                                DB::table('paid_affiliates')->insert(
                                    [
                                     'type' => 'C',
                                     'affiliate_id' => $aff->id,
                                    ]
                                );
                            }
                        }else{
                            $afincount++;
                            $affiliate_no[]= array(
                                'nombre'=>$n,
                                'razon'=>$result->razon,
                                'anio'=>$result->anio,
                            );
                            // $affiliate_no[] = get_object_vars(json_decode($result));

                        }
                        $Progress->advance();
                    });
                });

                Excel::create('Lista Cuota Afiliados no encontrados'.date("Y-m-d H:i:s"),function($excel)
                {

                    global $Progress,$affiliate_no, $affiliate_yes;
                    $excel->sheet('Afiliados No encontrados', function($sheet) use($affiliate_no) 
                    {
                        global $Progress,$affiliate_no;
                        $sheet->fromArray($affiliate_no);
                    });
                    $excel->sheet('Afiliados encontrados', function($sheet) use($affiliate_yes) 
                    {
                        global $Progress,$affiliate_yes;
                        $sheet->fromArray($affiliate_yes);
                    });
                })->store('xls', storage_path('excel/exports'));; 
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\nFound $aficount Affiliates\n
                    Not Found $afincount affiliates\n
                    Execution time $execution_time [minutes].\n");
            }
        }else {
            $this->error('Incorrect password!');
            exit();
        }
        
        
    }
}
