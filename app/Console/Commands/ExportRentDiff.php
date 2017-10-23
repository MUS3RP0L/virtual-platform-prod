<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\EconomicComplement;

class ExportRentDiff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:diff_rent';

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
        $count=0;
        $diff=0;
        $eco_coms=EconomicComplement::where('eco_com_procedure_id','=', 2)->get();  
        foreach ($eco_coms as $index => $eco) {
            $eco_old=$eco->affiliate->economic_complements()->where('eco_com_procedure_id', '=',1)->first();
            if ($eco_old) {
                $count++;
                if ($eco_old->total_rent <> $eco->total_rent) {
                    $diff++;
                }
            }
        }
        dd($count, $diff);
    }
}
