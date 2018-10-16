<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementProcedure;
use Muserpol\Due;
use Muserpol\Devolution;
use Muserpol\ObservationType;
use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;

class ImportTotalDuesRF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:total_due_rf';

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
                         $ci = trim(Util::removeSpaces($result->ci));
                         $affi=Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($ci),'0')."'")->first();
                         // $affi=Affiliate::where('identity_card', '=', $ci)->first();
                         if ($affi) {
                            $d=Devolution::where('affiliate_id','=', $affi->id)->where('observation_type_id','=',13)->first();
                            // dd($d);
                            if (!$d) {
                                $d=new Devolution();
                                $d->affiliate_id = $affi->id; 
                                $d->observation_type_id = 13; 
                                $d->start_eco_com_procedure_id = 13;
                                $d->save();
                            }
                                if (!Due::where('devolution_id','=',$d->id)->where('eco_com_procedure_id','=',11)->first()) {
                                    $due = new Due();
                                    $due->devolution_id=$d->id;
                                    $due->eco_com_procedure_id=11;
                                    $due->amount=$result->p_2013;
                                    $due->save();
                                }
                                if (!Due::where('devolution_id','=',$d->id)->where('eco_com_procedure_id','=',12)->first()) {
                                    $due = new Due();
                                    $due->devolution_id=$d->id;
                                    $due->eco_com_procedure_id=12;
                                    $due->amount=$result->s_2013;
                                    $due->save();
                                }
                                if (!Due::where('devolution_id','=',$d->id)->where('eco_com_procedure_id','=',9)->first()) {
                                    $due = new Due();
                                    $due->devolution_id=$d->id;
                                    $due->eco_com_procedure_id=9;
                                    $due->amount=$result->p_2014;
                                    $due->save();
                                }
                                if (!Due::where('devolution_id','=',$d->id)->where('eco_com_procedure_id','=',10)->first()) {
                                    $due = new Due();
                                    $due->devolution_id=$d->id;
                                    $due->eco_com_procedure_id=10;
                                    $due->amount=$result->s_2014;
                                    $due->save();
                                }
                                $total_dues=$d->dues()->whereIn('eco_com_procedure_id',[9,10,11,12])->sum('amount');
                                $d->total = ($d->total ?? 0) + $total_dues;
                                $d->balance = ($d->balance ?? 0) + $total_dues;
                                $d->save();
                                $affi_succ++;
                         }else{
                            $this->info($ci);
                             $affi_no++;
                         }
                         $Progress->advance();
                     });
                 });
                 $time_end = microtime(true);
                 $execution_time = ($time_end - $time_start)/60;
                 $Progress->finish();
                 $this->info("\n\n ---------\n
                     $affi_succ Affiliates Found\n
                     \tAffiliates NOT found $affi_no\n
                 Execution time $execution_time [minutes].\n");
             }
        }else {
            $this->error('Incorrect password!');
            exit();
        }
    }
}
