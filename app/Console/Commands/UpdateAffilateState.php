<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\EconomicComplement;

class UpdateAffilateState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:affiliate_state';

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
        global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            $time_start = microtime(true);
            $this->info("Working...\n");
            $Progress = $this->output->createProgressBar();
            $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
            $count = 0;
            $affiliates = Affiliate::all();
            foreach ($affiliates as $key => $a) {
                $eco = $a->economic_complements;
                if (sizeof($eco)) {
                    $eco = $a->economic_complements()->leftJoin('eco_com_procedures', 'eco_com_procedures.id', '=', 'economic_complements.eco_com_procedure_id')
                        ->orderBy('eco_com_procedures.sequence', 'desc')
                        ->select('economic_complements.id')
                        ->first();
                    $eco = EconomicComplement::find($eco->id);
                    $affiliate = $eco->affiliate;
                    switch ($eco->economic_complement_modality->economic_complement_type->id) {
                        case 1:
                            $affiliate->affiliate_state_id = 5;
                            break;
                        case 2:
                            $affiliate->affiliate_state_id = 4;
                            break;
                        case 3:
                            $affiliate->affiliate_state_id = 4;
                            break;
                        default:
                            $this->info("el complemento no tiene modalidad ->". $eco->id);
                            break;
                    }
                    $affiliate->save();

                }
            }
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start) / 60;
            $Progress->finish();

            $this->info("\n\nupdate $count states:\n
            Execution time $execution_time [minutes].\n");
        } else {
            $this->error('Incorrect password!');
            exit();
        }
    }
}
