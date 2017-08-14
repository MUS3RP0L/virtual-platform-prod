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

class UpdateDegreeToEcoCom extends Command implements SelfHandling
{
    protected $signature = 'update:degree_eco';
    protected $description = 'Realiza una copia del grado de afiliado al complemento';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
                $time_start = microtime(true);
                    $this->info("Working...\n");
                    $Progress = $this->output->createProgressBar();
                    $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                    $count=0;
                    $ncount=0;
                    $economic_complements = EconomicComplement::all();
                    foreach ($economic_complements as $eco) {
                        $Progress->advance();
                        if (!$eco->degree_id ) {
                            $count++;
                            $eco->degree_id = $eco->affiliate->degree_id;
                            $eco->save();
                        }else{
                            $ncount++;
                        }
                    }
                    $time_end = microtime(true);
                    $execution_time = ($time_end - $time_start)/60;
                    $Progress->finish();

                    $this->info("\n\nSet $count degrees into complement:\n
                        $ncount exists Degree in Complement\n
                    Execution time $execution_time [minutes].\n");
       }
       else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
