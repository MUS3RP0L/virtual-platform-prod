<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\Degree;
use Muserpol\AffiliateRecord;
use Muserpol\EconomicComplementApplicant;
use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;

class ImportSenasirsir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:senasir_sir';

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
       
        // dd(Util::getDegreeId_name("hola"));
       global $Progress, $affi_succ, $affi_no,$degree_count, $affiliate_no;
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
                        global $Progress, $affi_succ, $affi_no,$degree_count,$affiliate_no;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $ci = trim(Util::removeSpaces(trim($result->carnet)).((trim(Util::removeSpaces($result->num_com)) !='') ? '-'.$result->num_com: ''));
                        $afi=null;
                        if ($result->renta == 'TITULAR') {
                            $afi=Affiliate::whereRaw("split_part(ltrim(trim(identity_card),'0'), '-',1) ='".explode('-',ltrim(trim($ci),'0'))[0]."'")->first();
                        }else if($result->renta == 'DERECHOHABIENTE'){
                            $app=EconomicComplementApplicant::whereRaw("split_part(ltrim(trim(identity_card),'0'), '-',1) ='".explode('-',ltrim(trim($ci),'0'))[0]."'")->first();
                            if ($app) {   
                                if ($app->economic_complement) {

                                    $afi = $app->economic_complement->affiliate;
                                }
                            }
                        }
                        if ($afi) {
                            $degree=$afi->degree;
                            if ($degree) {
                                $degree=Degree::where('id','=',$degree->id)->first();
                                $this->info($degree);
                                $affiliate_no[] = json_decode($result);
                            }
                        }
                        $Progress->advance();
                    });
                });
                // dd($affiliate_no);
                Excel::create('Lista Afiliados NO importados de File Maker'.date("Y-m-d H:i:s"),function($excel) use($affiliate_no)
                {
                    global $affiliate_no;
                    $excel->sheet('afiliados no importados',function($sheet) use($affiliate_no){
                        global $affiliate_no;
                        $sheet->fromArray($affiliate_no);
                    });
                })->store('xls', storage_path('excel/exports'));
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\n ---------\n
                    $affi_succ Affiliates Found\n
                    \tGrados no Encontrados: $degree_count\n
                    \tAffiliates NOT found $affi_no\n


                Execution time $execution_time [minutes].\n");

            }
       }else {
           $this->error('Incorrect password!');
           exit();
       } 
    }
}
