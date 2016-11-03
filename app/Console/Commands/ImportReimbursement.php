<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Affiliate;
use Muserpol\Reimbursement;


class ImportReimbursement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'import:reimbursement';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Import reimbursement provided by General Command';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        global $NotFounf, $NewReimbursement, $Progress, $FolderName, $Date;

        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder ' . $FolderName . '? [y|N]') && $FolderName) {

                // ini_set('upload_max_filesize', '99999M');
                // ini_set('post_max_size', '99999M');
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '-1');
                ini_set('max_input_time', '-1');
                set_time_limit('-1');

                $time_start = microtime(true);
                $this->info("Importing...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {

                    $rows->each(function($result) {

                        global $NotFounf, $NewReimbursement, $Progress, $FolderName, $Date;

                        // ini_set('upload_max_filesize', '9999M');
                        // ini_set('post_max_size', '9999M');
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');

                        $month_year = Carbon::createFromDate(Util::formatYear($result->a_o), Util::zero($result->mes), 1)->toDateString();
                        $Date = Util::zero($result->mes) . "-" . Util::formatYear($result->a_o);

                        $affiliate = Affiliate::where('identity_card', '=', Util::zero($result->car))->first();

                        if (!$affiliate) {

                            $affiliate = Affiliate::where('last_name', '=', $result->pat)->where('mothers_last_name', '=', $result->mat)
                                                ->where('birth_date', '=', $result->nac)->where('date_entry', '=', $result->ing)
                                                ->where('identity_card', '=', Util::RepeatedIdentityCard($result->car))->first();
                        }
                        if($affiliate) {

                            if (Util::decimal($result->sue)<> 0) {

                                $reimbursement = Reimbursement::where('month_year', '=', $month_year)
                                                    ->where('affiliate_id', '=', $affiliate->id)->first();

                                if (!$reimbursement) {

                                    $reimbursement = new Reimbursement;
                                    $reimbursement->user_id = 1;
                                    $reimbursement->affiliate_id = $affiliate->id;
                                    $reimbursement->month_year = $month_year;
                                    $reimbursement->base_wage = Util::decimal($result->sue);
                                    $reimbursement->seniority_bonus = Util::decimal($result->cat);
                                    $reimbursement->study_bonus = Util::decimal($result->est);
                                    $reimbursement->position_bonus = Util::decimal($result->carg);
                                    $reimbursement->border_bonus = Util::decimal($result->fro);
                                    $reimbursement->east_bonus = Util::decimal($result->ori);
                                    $reimbursement->gain = Util::decimal($result->gan);
                                    $reimbursement->payable_liquid = Util::decimal($result->pag);
                                    $reimbursement->quotable = (FLOAT)$reimbursement->base_wage +
                                                           (FLOAT)$reimbursement->seniority_bonus +
                                                           (FLOAT)$reimbursement->study_bonus +
                                                           (FLOAT)$reimbursement->position_bonus +
                                                           (FLOAT)$reimbursement->border_bonus +
                                                           (FLOAT)$reimbursement->east_bonus;

                                    $reimbursement->total = Util::decimal($result->mus);
                                    $percentage = round(($reimbursement->total / $reimbursement->quotable) * 100, 1);
                                    if ($percentage == 2.5){
                                        $reimbursement->retirement_fund = $reimbursement->total * 1.85 / $percentage;
                                        $reimbursement->mortuary_quota = $reimbursement->total * 0.65 / $percentage;
                                    }
                                    $reimbursement->save();
                                    $NewReimbursement ++;
                                }

                            }

                        }
                        else{$NotFounf ++;}

                        $Progress->advance();
                    });

                });

                $time_end = microtime(true);

                $execution_time = ($time_end - $time_start)/60;

                $NewReimbursement = $NewReimbursement ? $NewReimbursement : "0";
                $NotFounf = $NotFounf ? $NotFounf : "0";

                $Progress->finish();

                $this->info("\n\nReport $Date:\n\n
                    $NewReimbursement new reimbursements.\n
                    $NotFounf affiliate not found .\n
                    Execution time $execution_time [minutes].\n");

                \Storage::disk('local')->put($Date.'.txt', "\n\nReport:\n\n
                   $NewReimbursement new reimbursements.\n
                    $NotFounf affiliate not found .\n
                    Execution time $execution_time [minutes].\n");
            }
        }
        else{
            $this->error('Incorrect password!');
        }
    }



}
