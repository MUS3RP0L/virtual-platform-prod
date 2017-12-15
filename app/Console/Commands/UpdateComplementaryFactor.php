<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\EconomicComplementProcedure;
use Muserpol\EconomicComplement;
class UpdateComplementaryFactor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:complementary_factor';

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

        global $Progress, $update;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            // $year = $this->ask('Enter the year');
            // $semester = $this->anticipate('Enter the semester: ', ['Primer', 'Segundo']);
            if($this->confirm('Are you sure? [y|N]') /*&& $year && $semester*/)
                {   $time_start = microtime(true);
                    $this->info("Working...\n");
                    $Progress = $this->output->createProgressBar();
                    $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                    $Progress->advance();

                    // $procedure=EconomicComplementProcedure::where('semester','like',$semester)->whereYear('year', '=', $whereYearr)->first();
                    foreach (EconomicComplementProcedure::all() as $procedure) {
                    if ($procedure) {
                        $update=0;
                        $ecos = $procedure->economic_complements;
                        foreach ($ecos as $key => $eco) {
                            if ($eco->complementary_factor) {
                                if ($eco->complementary_factor < 1) {
                                    $eco->complementary_factor = $eco->complementary_factor * 100;
                                    $eco->save();
                                    $update++;
                                }
                            }
                            $Progress->advance();
                        }

                        $time_end = microtime(true);
                        $execution_time = ($time_end - $time_start)/60;
                        $Progress->finish();

                        $this->info("\n\nUpdate ($update) complementary factors".$procedure->getFullname()."\n
                            Execution time $execution_time [minutes].\n");
                    }
                    }
                }
                else {
                    $this->error(' Enter year and semester!');
                }
            }
            else {
                $this->error('Incorrect password!');
                exit();
            }

        
    }
}
