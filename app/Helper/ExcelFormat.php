<?php 
namespace Muserpol\Helper;
use Muserpol\EconomicComplement;
use Auth;
use DB;
/**
* 
*/
class ExcelFormat 
{
	
	function __construct()
	{
		# code...
	}

	public function FormatoObservados($complements_ids)
	{
			
			//class for revision
		 	// $economic_complements=EconomicComplement::whereIn('economic_complements.id',$complements_ids)
    //         ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
    //         ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
    //         ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
    //         ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
    //         ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
    //         ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
    //         ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
    //         ->distinct('economic_complements.id')
    //         ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as       Complemento_Final','affiliates.id as affiliate_id')
    //         ->get();
    //         Log::info($economic_complements);
	   //      $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
	   //      foreach ($economic_complements as $c) {
	   //        # code...
	   //        $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
	   //        $observacion = "";
	   //        foreach ($observaciones as $obs) {
	   //          # code...
	   //          $observacion = $observacion." | ".$obs->message; 
	   //        }

	   //        array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
	   //      }
	   //  return $rows;    
	}

}


?>