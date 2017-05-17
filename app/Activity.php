<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Muserpol\Helper\Util;
use Auth;

define("ACTIVITY_TYPE_UPDATE_AFFILIATE", 1);
define("ACTIVITY_TYPE_UPDATE_CONTRIBUTION", 2);
define("ACTIVITY_TYPE_UPDATE_SPOUSE", 3);
define("ACTIVITY_TYPE_UPDATE_ECONOMIC_COMPLEMENT", 4);
define("ACTIVITY_TYPE_UPDATE_ECO_COM_APPLICANT", 5);
define("ACTIVITY_TYPE_UPDATE_ECO_COM_SUBMITTED_DOCUMENT", 6);

define("ACTIVITY_TYPE_CREATE_SPOUSE", 7);
define("ACTIVITY_TYPE_CREATE_ECONOMIC_COMPLEMENT", 8);
define("ACTIVITY_TYPE_CREATE_ECO_COM_APPLICANT", 9);
define("ACTIVITY_TYPE_CREATE_ECO_COM_SUBMITTED_DOCUMENT", 10);

class Activity extends Model
{
    public $timestamps = true;
	protected $softDelete = false;

	public static function updateAffiliate($affiliate)
	{
		if (Auth::user())
		{
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $affiliate->id;
            //$affiliate->registration = Util::CalcRegistration($affiliate->birth_date, $affiliate->last_name, $affiliate->mothers_last_name, $affiliate->first_name, $affiliate->gender);
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_AFFILIATE;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Afiliado', $affiliate);
			$activity->save();
		}
	}

	public static function updateContribution($contribution)
	{
		if (Auth::user())
		{   $affiliate = Affiliate::findOrFail($contribution->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $contribution->affiliate_id;
			$activity->contribution_id = $contribution->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_CONTRIBUTION;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Aporte', $affiliate);
			$activity->save();
		}
	}

	public static function updateSpouse($spouse)
	{
		if (Auth::user())
		{
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
            $affiliate = Affiliate::idIs($spouse->affiliate_id)->first();
            $sex = $affiliate->gender == 'M' ? 'F':'M';
            $activity->affiliate_id = $spouse->affiliate_id;
			$activity->spouse_id = $spouse->id;
           // $spouse->registration = Util::CalcRegistration($spouse->birth_date, $spouse->last_name, $spouse->mothers_last_name, $spouse->first_name, $sex);
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_SPOUSE;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Conyuge', $spouse);
			$activity->save();
		}
	}

	public static function createdSpouse($spouse)
	{
		if (Auth::user())
		{
		  $activity = new Activity;
			$activity->user_id = Auth::user()->id;
            $activity->spouse_id = $spouse->id;
            $affiliate = Affiliate::idIs($spouse->affiliate_id)->first();
            $sex = $affiliate->gender == 'M' ? 'F':'M';
			$activity->affiliate_id = $spouse->affiliate_id;
            $spouse->registration = Util::CalcRegistration($spouse->birth_date, $spouse->last_name, $spouse->mothers_last_name, $spouse->first_name, $sex);
			$spouse->save();
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_SPOUSE;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Conyuge', $spouse);
			$activity->save();
		}
	}

    public static function createdEconomicComplement($ecomplement)
	{
		if (Auth::user())
		{   $affiliate = Affiliate::findOrFail($ecomplement->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $ecomplement->affiliate_id;
			$activity->economic_complement_id = $ecomplement->id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_ECONOMIC_COMPLEMENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Complemento Económico', $affiliate);
			$activity->save();
		}
	}

    public static function updateEconomicComplement($ecomplement)
	{
		if (Auth::user())
		{   $affiliate = Affiliate::findOrFail($ecomplement->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $ecomplement->affiliate_id;
			$activity->economic_complement_id = $ecomplement->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_ECONOMIC_COMPLEMENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Actualizó Complemento Económico', $affiliate);
			$activity->save();
		}
	}

    public static function createdEconomicComplementApplicant($ec_applicant)
	{
		if (Auth::user())
		{
            $economic_complement = EconomicComplement::findOrFail($ec_applicant->economic_complement_id);
            $affiliate = Affiliate::findOrFail($economic_complement->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $economic_complement->affiliate_id;
			$activity->economic_complement_id = $economic_complement->id;
            $activity->eco_com_applicant_id = $ec_applicant->id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_ECO_COM_APPLICANT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Solicitante de Complemento Económico', $affiliate);
			$activity->save();
		}
	}

    public static function updateEconomicComplementApplicant($ec_applicant)
	{
		if (Auth::user())
		{   $economic_complement = EconomicComplement::findOrFail($ec_applicant->economic_complement_id);
            $affiliate = Affiliate::findOrFail($economic_complement->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $economic_complement->affiliate_id;
			$activity->economic_complement_id = $economic_complement->id;
            $activity->eco_com_applicant_id = $ec_applicant->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_ECO_COM_APPLICANT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Actualizó al Solicitante de Complemento Económico', $affiliate);
			$activity->save();
		}
	}

    public static function createdEconomicComplementSubmittedDocument($ec_submittedDocument)
	{
		if (Auth::user())
		{
            $economic_complement = EconomicComplement::findOrFail($ec_submittedDocument->economic_complement_id);
            $affiliate = Affiliate::findOrFail($economic_complement->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $economic_complement->affiliate_id;
			$activity->economic_complement_id = $economic_complement->id;
            $activity->eco_com_applicant_id = $ec_submittedDocument->id;
            $activity->eco_com_submitted_document_id = $ec_submittedDocument->id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_ECO_COM_SUBMITTED_DOCUMENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó Documentos Presentados para Complemento Económico', $affiliate);
			$activity->save();
		}
	}

    public static function updateEconomicComplementSubmittedDocument($ec_submittedDocument)
	{
		if (Auth::user())
		{
            $economic_complement = EconomicComplement::findOrFail($ec_submittedDocument->economic_complement_id);
            $affiliate = Affiliate::findOrFail($economic_complement->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $economic_complement->affiliate_id;
			$activity->economic_complement_id = $economic_complement->id;
            $activity->eco_com_applicant_id = $ec_submittedDocument->id;
            $activity->eco_com_submitted_document_id = $ec_submittedDocument->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_ECO_COM_SUBMITTED_DOCUMENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Actualizó Documentos Presentados para Complemento Económico', $affiliate);
			$activity->save();
		}
	}


}
