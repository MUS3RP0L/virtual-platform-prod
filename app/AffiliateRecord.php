<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

use Muserpol\Helper\Util;
use Auth;

define("NOTE_TYPE_UPDATE_AFFILIATE_STATE", 1);
define("NOTE_TYPE_UPDATE_AFFILIATE_DEGREE", 2);
define("NOTE_TYPE_UPDATE_AFFILIATE_UNIT", 3);

class AffiliateRecord extends Model
{
	public static function UpdatingAffiliate($affiliate)
	{

		$last_affiliate = Affiliate::where('id', '=', $affiliate->id)->firstOrFail();

		if ($last_affiliate->affiliate_state_id <> $affiliate->affiliate_state_id) {

			$aff_record = new AffiliateRecord;
			if (Auth::user()) {$user_id = Auth::user()->id;}else{$user_id = 1;}
			$aff_record->user_id = $user_id;
			$aff_record->affiliate_id = $affiliate->id;
			$aff_record->date = $affiliate->change_date;
			$aff_record->affiliate_state_id = $affiliate->affiliate_state_id;
			$aff_record->type_id = NOTE_TYPE_UPDATE_AFFILIATE_STATE;
			$affiliate_state = AffiliateState::where('id', $affiliate->affiliate_state_id)->first();
			$aff_record->message = "Afiliado cambio de estado a " . $affiliate_state->name;
			$aff_record->save();
		}

		if ($last_affiliate->degree_id <> $affiliate->degree_id) {
			$aff_record = new AffiliateRecord;
			if (Auth::user()) {$user_id = Auth::user()->id;}else{$user_id = 1;}
			$aff_record->user_id = $user_id;
			$aff_record->affiliate_id = $affiliate->id;
			$aff_record->date = $affiliate->change_date;
			$aff_record->degree_id = $affiliate->degree_id;
			$aff_record->type_id = NOTE_TYPE_UPDATE_AFFILIATE_DEGREE;
        	$degree = Degree::where('id', $affiliate->degree_id)->first();
			$aff_record->message = "Afiliado cambio de grado a " . $degree->shortened;
			$aff_record->save();
		}

		if ($last_affiliate->unit_id <> $affiliate->unit_id) {
			$aff_record = new AffiliateRecord;
			if (Auth::user()) {$user_id = Auth::user()->id;}else{$user_id = 1;}
			$aff_record->user_id = $user_id;
			$aff_record->affiliate_id = $affiliate->id;
			$aff_record->date = $affiliate->change_date;
			$aff_record->unit_id = $affiliate->unit_id;
			$aff_record->type_id = NOTE_TYPE_UPDATE_AFFILIATE_UNIT;
        	$unit = Unit::where('id', $affiliate->unit_id)->first();
			$aff_record->message = "Afiliado cambio de unidad a " . $unit->shortened;
			$aff_record->save();
		}
	}

	public static function CreatedAffiliate($affiliate)
	{
		if ($affiliate->affiliate_state_id) {

			$aff_record = new AffiliateRecord;
			if (Auth::user()) {$aff_record->$user_id = Auth::user()->id;}else{$aff_record->user_id = 1;}
			$aff_record->affiliate_id = $affiliate->id;
			$aff_record->date = $affiliate->change_date;
			$aff_record->affiliate_state_id = $affiliate->affiliate_state_id;
			$aff_record->type_id = NOTE_TYPE_UPDATE_AFFILIATE_STATE;
			$affiliate_state = AffiliateState::where('id', $affiliate->affiliate_state_id)->first();
			$aff_record->message = "Afiliado ingresó de " . $affiliate_state->name;
			$aff_record->save();
		}

		if ($affiliate->degree_id) {

			$aff_record = new AffiliateRecord;
			if (Auth::user()) {$aff_record->$user_id = Auth::user()->id;}else{$aff_record->user_id = 1;}
			$aff_record->affiliate_id = $affiliate->id;
			$aff_record->date = $affiliate->change_date;
			$aff_record->degree_id = $affiliate->degree_id;
			$aff_record->type_id = NOTE_TYPE_UPDATE_AFFILIATE_DEGREE;
        	$degree = Degree::where('id', $affiliate->degree_id)->first();
			$aff_record->message = "Afiliado creado con grado de " . $degree->shortened;
			$aff_record->save();
		}

		if ($affiliate->unit_id) {

			$aff_record = new AffiliateRecord;
			if (Auth::user()) {$aff_record->$user_id = Auth::user()->id;}else{$aff_record->user_id = 1;}
			$aff_record->affiliate_id = $affiliate->id;
			$aff_record->date = $affiliate->change_date;
			$aff_record->unit_id = $affiliate->unit_id;
			$aff_record->type_id = NOTE_TYPE_UPDATE_AFFILIATE_UNIT;
        	$unit = Unit::where('id', $affiliate->unit_id)->first();
			$aff_record->message = "Afiliado ingresó a la unidad de " . $unit->shortened;
			$aff_record->save();

		}

	}

	public function getAllDate()
    {
    	return Util::getAllDate($this->date);
    }
}
