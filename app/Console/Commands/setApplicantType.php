<?php

namespace Muserpol\Console\Commands;


use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;

use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementApplicant;

class setApplicantType extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $signature = 'set:type';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $ecom = EconomicComplement::whereYear('economic_complements.year','=', 2016)->where('economic_complements.semester','=','Segundo')
                                     ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                     ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                     ->select('economic_complements.id','eco_com_types.id as tid','eco_com_types.name')->orderBy('economic_complements.id','ASC')->get();
        foreach ($ecom as $item) {
            //dd($item->id.' '.$item->tid.' '.$item->name);
            $eco_app = EconomicComplementApplicant::where('economic_complement_id','=',$item->id)->first();
            if($eco_app)
            {
                $eco_app->eco_com_applicant_type_id = $item->tid;
                $eco_app->save();
            }
        }

    }
}
