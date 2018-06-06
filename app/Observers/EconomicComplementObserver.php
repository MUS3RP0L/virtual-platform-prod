<?php

namespace Muserpol\Observers;

use Muserpol\EconomicComplement;
use Muserpol\AffiliateObservation;
use Log;
use Muserpol\EconomicComplementRecord;
use Muserpol\EconomicComplementObservation;
use Muserpol\Helper\Util;
use Auth;
use Carbon\Carbon;
class EconomicComplementObserver{


    public function created(EconomicComplement $economic_complement)
    {
        $record = new EconomicComplementRecord;
        $record->user_id = Auth::user()->id;
        $record->economic_complement_id = $economic_complement->id;
        $record->message = "El usuario ".Util::getFullNameuser()." creó el trámite ".$economic_complement->code." ";
        $record->save();
        
        // Creando observaciones del affiliado en caso de que tenga el hdp
        // $affiliate = Affiliate::find($economic_complement->affliliate_id);
       
    }

    public function updating(EconomicComplement $economic_complement)
    {
      
        $old_economic_complement=EconomicComplement::find($economic_complement->id);
        if ( $old_economic_complement->state <> $economic_complement->state && $economic_complement->state<>'Received') {
            $record=new EconomicComplementRecord;
            $record->user_id=Auth::user()->id ?? 1;
            $record->economic_complement_id=$economic_complement->id;
            $record->message="El usuario ".Util::getFullNameuser()." ".Util::wfStateName($economic_complement->wf_current_state_id)." el trámite ".$economic_complement->code.".";
            $record->save();
        }

        if ($old_economic_complement->wf_current_state_id <> $economic_complement->wf_current_state_id) {
            $record=new EconomicComplementRecord;
            $record->user_id=Auth::user()->id ?? 1;
            $record->economic_complement_id=$economic_complement->id;

            if ($economic_complement->eco_com_state_id == 1 || $economic_complement->eco_com_state_id == 2 || $economic_complement->eco_com_state_id == 3 || $economic_complement->eco_com_state_id == 17 || $economic_complement->eco_com_state_id == 18 || $economic_complement->eco_com_state_id == 15) {
                $record->message="El usuario ".Util::getFullNameuser()." derivo el tramite ".$economic_complement->code." de ".$old_economic_complement->wf_state->name." a ".$economic_complement->wf_state->name." (Por una recalificacion ).";
            }else{
                $record->message="El usuario ".Util::getFullNameuser()." derivo el tramite ".$economic_complement->code." de ".$old_economic_complement->wf_state->name." a ".$economic_complement->wf_state->name.".";
            }
            $record->save();
        }
        if ($old_economic_complement->degree_id <> $economic_complement->degree_id) {
            Log::info("degree");
            $record = new EconomicComplementRecord;
            $record->user_id = Auth::user()->id ?? 1;
            $record->economic_complement_id = $economic_complement->id;
            $record->message = "El usuario " . Util::getFullNameuser() . " actualizó  el grado de " . ($old_economic_complement->degree->name ?? 'sin grado') . " a " . $economic_complement->degree->name . " del trámite ". $economic_complement->code . ".";
            $record->save();
        }
        if ($old_economic_complement->category_id <> $economic_complement->category_id) {
            Log::info("category");
            $record = new EconomicComplementRecord;
            $record->user_id = Auth::user()->id ?? 1;
            $record->economic_complement_id = $economic_complement->id;
            $record->message = "El usuario " . Util::getFullNameuser() . " actualizó  la categoría de " . ($old_economic_complement->category->name ?? 'sin categoría') . " a " . $economic_complement->category->name . " del trámite ". $economic_complement->code .".";
            $record->save();
        }

    }

}