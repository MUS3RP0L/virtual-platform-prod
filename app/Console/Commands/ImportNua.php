<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;

class ImportNua extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:nua';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
        public function handle()
    {
        global $Progress, $FolderName;

        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {

                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%");

                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {

                    $rows->each(function($result) {

                        global $Progress, $FolderName;

                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');

                        if (Affiliate::where('identity_card', '=', $result->identity_card)->first() <> null and $result->nua <> 'NULL') {                            
                            
                            $affiliate = Affiliate::where('identity_card', '=', $result->identity_card)->first();
                            $affiliate->nua = $result->nua;

                            $affiliate->save();

                            $economic_complement = EconomicComplement::affiliateIs($affiliate->id)->first();

                            $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

                            $eco_com_applicant->nua = $affiliate->nua;

                            $eco_com_applicant->save();       
                        }            

                        $Progress->advance();

                    });

                });

                $time_end = microtime(true);

                $Progress->finish();

            }
        }
        else{
            $this->error('Incorrect password!');
            exit();
        }

    }
}
