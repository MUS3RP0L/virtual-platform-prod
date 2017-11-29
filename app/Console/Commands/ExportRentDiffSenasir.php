<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Muserpol\EconomicComplement;
use Muserpol\Affiliate;

use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use stdClass;
use DB;

class ExportRentDiffSenasir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:diff_rent_senasir';

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
        global $diffs,$diff_olds;
        $count=0;
        $diff=0;

        $columns = ', economic_complements.affiliate_id as afi_id,economic_complements.total_rent as renta_total';
        $eco_coms=EconomicComplement::where('eco_com_procedure_id','=', 6)->leftJoin('affiliates', 'economic_complements.affiliate_id','=', 'affiliates.id')
        ->whereIn('affiliates.pension_entity_id',[5])->select('economic_complements.id')->get()->pluck('id');  
        $eco_coms=EconomicComplement::whereIn('economic_complements.id',$eco_coms)
        ->ecocominfo()
        ->applicantinfo()
        ->affiliateinfo()
        ->select(DB::raw(EconomicComplement::basic_info_colums()."".$columns.""))
        ->get();

        

        $eco_final=array();
        foreach ($eco_coms as $index => $eco) {

            $eco_old=Affiliate::where('id','=',$eco->afi_id)->first()->economic_complements()->where('eco_com_procedure_id', '=',2)->first();
            if ($eco_old) {
                $count++;
                $s=floatval($eco->renta_total);

                if (floatval($eco_old->total_rent).'' <>  floatval($s).'') {

                $eco->setAttribute("renta_anterior",$eco_old->total_rent);
                $this->info("----------");
                $this->info($eco);
                $this->info("----------");
                //$objeto = new stdClass;
                // $objeto = (stdClass) json_encode($eco);
                // dd($objeto);
                $eco_final[]=(array)json_decode($eco);
                // $this->info("a". $eco->total_rent);
                // $this->info("code".$eco->code);
                // $this->info("old:". $eco_old->total_rent);
                // $this->info("code:". $eco_old->code);

             //   return 0;
                    $diff++;
                    // $diffs[]=$eco->id;
                     // $diff_olds[]=$eco_old->id;
                }
            }
        }

        


       

        // $eco_olds = EconomicComplement::whereIn('economic_complements.id', $diff_olds)
        //             ->select('total_rent as renta_anterior')
        //             ->get()->pluck('renta_anterior');


        //  $this->info("eco_olds: ".$eco_olds->count());

        

        // $economic_complements=EconomicComplement::whereIn('economic_complements.id', $diffs)
        // ->ecocominfo()
        // ->applicantinfo()
        // ->affiliateinfo()
        // ->select(DB::raw(EconomicComplement::basic_info_colums()."".$columns.""))
        // ->get();
        // $this->info('eco: '.$economic_complements->count());
        // for ($i = 0; $i < sizeof($economic_complements); $i++) {
            
        //     $this->info('\n con renta anterior');

        //     $economic_complements[$i]->setAttribute("renta_anterior",$eco_olds[$i]->renta_anterior);

        //     $this->info($economic_complements[$i]);

        //     $this->info('\n -------------------------------------------------');
        // }


        $data = $eco_final;
        Util::excelSave('Lista Afiliados que varian las rentas con Senasir', 'hoja', $data, 'excel/exports');
    }
}
