<?php
namespace Muserpol\Observers;
use Log;
use Muserpol\AffiliateRecord;
use Muserpol\AffiliateObservation;
use Muserpol\Helper\Util;
use Auth;
use Carbon\Carbon;
use Muserpol\User;
class AffiliateObservationObserver
{

    public function created(AffiliateObservation $observation)
    {
        Log::info('created');
        Log::info($observation);
        
        $aff_record = new AffiliateRecord;
        if (Auth::user()) {$user_id = Auth::user()->id;}else{$user_id = 1;}
        $user = User::find($user_id);
        $aff_record->user_id = $user->id;
        $aff_record->affiliate_id = $observation->affiliate_id;
        $aff_record->date = Carbon::now();
        $aff_record->type_id = 6;// 6 es por la observacion
        $aff_record->message = $user->getFullname()." creó la Observación ".$observation->observationType->name;
        $aff_record->save();
   
    }
    public function deleting(AffiliateObservation $observation)
    {
        $aff_record = new AffiliateRecord;
        if (Auth::user()) {$user_id = Auth::user()->id;}else{$user_id = 1;}
        $user = User::find($user_id);
        $aff_record->user_id = $user->id;
        $aff_record->affiliate_id = $observation->affiliate_id;
        $aff_record->date = Carbon::now();
        $aff_record->type_id = 6;// 6 es por la observacion
        $aff_record->message = $user->getFullname()." borro la Observación ".$observation->observationType->name;
        $aff_record->save();
    }
}