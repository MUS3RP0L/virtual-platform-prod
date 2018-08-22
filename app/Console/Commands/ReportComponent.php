<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use DB;
use Log;


class ReportComponent extends Command
{
    
    protected $signature = 'report:component';  
    protected $description = 'Comparacion de componentes de APS de 2018 y 2017';
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        global $result,$rows;
        $eco2018= DB::table('eco_com_applicants')
                    ->select(DB::raw("economic_complements.id,eco_com_applicants.identity_card as bene_ci, eco_com_applicants.first_name bene_nombre,eco_com_applicants.last_name as bene_paterno,eco_com_applicants.mothers_last_name as bene_materno, economic_complements.code as codigo, economic_complements.reception_date as fecha, economic_complements.year as ano, economic_complements.semester as semestre, economic_complements.total_rent as renta, economic_complements.aps_total_cc,economic_complements.aps_total_fsa, economic_complements.aps_total_fs,  economic_complements.aps_disability as renta_invalidez, affiliates.identity_card as afi_ci, affiliates.first_name as afi_nombre,affiliates.last_name as paterno, affiliates.mothers_last_name as materno, pension_entities.name as ente_gestor, eco_com_types.name as modalidad"))
                    ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                    ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                    ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                    ->where('pension_entities.id', '<>', 5)
                    ->where('economic_complements.eco_com_procedure_id', '=', 7)
                    ->where('economic_complements.total_rent', '>', 0)->get();

        foreach($eco2018 as $item2018) 
        {
            $eco2017= DB::table('eco_com_applicants')
                    ->select(DB::raw("economic_complements.id,eco_com_applicants.identity_card as bene_ci, eco_com_applicants.first_name bene_nombre,eco_com_applicants.last_name as bene_paterno,eco_com_applicants.mothers_last_name as bene_materno, economic_complements.code as codigo, economic_complements.reception_date as fecha, economic_complements.year as ano, economic_complements.semester as semestre, economic_complements.total_rent as renta, economic_complements.aps_total_cc,economic_complements.aps_total_fsa, economic_complements.aps_total_fs,  economic_complements.aps_disability as renta_invalidez, affiliates.identity_card as afi_ci, affiliates.first_name as afi_nombre,affiliates.last_name as paterno, affiliates.mothers_last_name as materno, pension_entities.name as ente_gestor, eco_com_types.name as modalidad"))
                    ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                    ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                    ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                    ->where('pension_entities.id', '<>', 5)
                    ->where('economic_complements.eco_com_procedure_id', '=', 6)
                    ->where('economic_complements.total_rent', '>', 0)
                    ->where('eco_com_applicants.identity_card','=',rtrim($item2018->bene_ci))->first();
            if($eco2017)
            {

            
                    $comp2018=0;
                    if ($item2018->aps_total_fsa > 0) 
                    {
                        $comp2018++;
                    }
                    if ($item2018->aps_total_cc > 0) 
                    {
                        $comp2018++;
                    }
                    if ($item2018->aps_total_fs > 0) 
                    {
                        $comp2018++;
                    }
                    
                    $comp2017=0;
                    if ($eco2017->aps_total_fsa > 0) 
                    {
                        $comp2017++;
                    }
                    if ($eco2017->aps_total_cc > 0) 
                    {
                        $comp2017++;
                    }
                    if ($eco2017->aps_total_fs > 0) 
                    {
                        $comp2017++;
                    }	
                    
                    if($comp2018 <> $comp2017 )
                    {
                        $result[]= $item2018;
                    }
                    Log::info($result);
            }
                    
        }
        
        //dd($result);
       
        
      
      /*  Excel::create('COMPONENTES_DIFERENTES',function($excel)
        {
            global $result;
            $excel->sheet('COMP_DIFERENTES1',function($sheet){
                global $result;
                $sheet->fromArray($result);
            });
        })->store('xls', storage_path('excel/exports'));*/
    
      /*  $rows = array('id,bene_ci, bene_nombre,bene_paterno,bene_materno, codigo, fecha, ano, semestre, renta, aps_total_cc,aps_total_fsa,aps_total_fs,renta_invalidez,afi_ci,afi_nombre,paterno,materno,ente_gestor,modalidad');
        array_push($result, $rows);
        Excel::create('informe hdp',function($excel)
        {

            global $result,$rows;
                       $excel->sheet('componente',function($sheet) {

                            global $result;

                             $sheet->fromArray($result,null, 'A1', false, false);
                            /* $sheet->cells('A1:I1', function($cells) {

                             // manipulate the range of cells
                             $cells->setBackground('#058A37');
                             $cells->setFontColor('#ffffff');  
                             $cells->setFontWeight('bold');

                             });

                         });

        })->store('xls', storage_path('excel/exports'));*/





    }
}
