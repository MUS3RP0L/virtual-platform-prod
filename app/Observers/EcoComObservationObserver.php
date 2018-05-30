<?php

namespace Muserpol\Observers;

use Muserpol\EconomicComplementObservation;
use Log;
use Muserpol\EconomicComplementRecord;
use Muserpol\Helper\Util;
use Auth;
use Carbon\Carbon;
class EcoComObservationObserver
{
    public function created(EconomicComplementObservation $observation)
    {
        // Log::info('created');
        // Log::info($observation);
        $record = new EconomicComplementRecord;
        $record->economic_complement_id = $observation->economic_complement_id;
        $record->user_id = Auth::user()->id;
        if( $observation->observation_type_id==11 )
        {
            $record->message = 'El usuario '.Auth::user()->username.' creó una Nota ';
        }else{
            $record->message = 'El usuario '.Auth::user()->username.' creó la observación '.$observation->observationType->name.'. ';
        }

        $record->save();
    }
    public function deleting(EconomicComplementObservation $observation)
    {
        // Log::info('borrando');
        // Log::info($observation);
        $record = new EconomicComplementRecord;
        $record->economic_complement_id = $observation->economic_complement_id;
        $record->user_id = Auth::user()->id;
        if( $observation->observation_type_id==11 )
        {
            $record->message = 'El usuario '.Auth::user()->username.' borro una Nota ';
        }else{
            $record->message = 'El usuario '.Auth::user()->username.' borro la observación '.$observation->observationType->name.'. ';
        }
        $record->save();
    }

    public function updating(EconomicComplementObservation $observation)
    {
        $old = EconomicComplementObservation::find($observation->id);
        
        $message = 'El usuario '.Auth::user()->username.' modifico ';
        if($observation->observation_type_id==11)
        {
            $message = $message .' la Nota, ';
        }else{
            $message = $message .' la observacion '.$observation->observationType->name.', ';
        }

        if($observation->message != $old->message)
        {
            $message = $message . ' el mensaje de - '.$old->message.' - a - '.$observation->message.', ';
        }
        
        if($observation->is_enabled != $old->is_enabled)
        {
            $message = $message . ' de '.Util::getEnabledLabel($old->is_enabled).' a '.Util::getEnabledLabel($observation->is_enabled).', ';
        }
    
        $message = $message . ' ';

        $record = new EconomicComplementRecord;
        $record->user_id = Auth::user()->id;
        $record->economic_complement_id = $observation->economic_complement_id;
        $record->message = $message;
        $record->save();

    }

}