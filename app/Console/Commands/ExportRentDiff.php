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
        $eco_coms=EconomicComplement::where('eco_com_procedure_id','=', 6)->leftJoin('affiliates', 'economic_complements.affiliate_id','=', 'affiliates.id')
        ->whereIn('affiliates.pension_entity_id',[1,2,3,4])->select('economic_complements.id')->get()->pluck('id')
        ;  
        $eco_coms=EconomicComplement::whereIn('id',$eco_coms)->get();
        
        foreach ($eco_coms as $index => $eco) {
            $eco_old=$eco->affiliate->economic_complements()->where('eco_com_procedure_id', '=',2)->whereRaw('economic_complements.aps_disability is null')->first();
            if ($eco_old) {
                $count++;
                $s=floatval($eco->aps_total_cc) + floatval($eco->aps_total_fs) + floatval($eco->aps_total_fsa);
                if (floatval($eco_old->total_rent).'' <>  floatval($s).'') {
                    $diff++;
                    // dd($eco->id,floatval($eco_old->total_rent).'', floatval($s).'');
                }
            }
        }
        dd($count, $diff);
    }
}
