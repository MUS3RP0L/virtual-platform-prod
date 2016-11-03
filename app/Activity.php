<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Muserpol\Helper\Util;
use Auth;

define("ACTIVITY_TYPE_UPDATE_AFFILIATE", 1);
define("ACTIVITY_TYPE_UPDATE_RETIREMENT_FUND", 2);
define("ACTIVITY_TYPE_UPDATE_CONTRIBUTION", 3);
define("ACTIVITY_TYPE_UPDATE_DOCUMENT", 4);
define("ACTIVITY_TYPE_UPDATE_ANTECEDENT", 5);
define("ACTIVITY_TYPE_UPDATE_SPOUSE", 6);
define("ACTIVITY_TYPE_UPDATE_APPLICANT", 7);

define("ACTIVITY_TYPE_CREATE_SPOUSE", 8);
define("ACTIVITY_TYPE_CREATE_APPLICANT", 9);
define("ACTIVITY_TYPE_CREATE_RETIREMENT_FUND", 10);
define("ACTIVITY_TYPE_CREATE_DOCUMENT", 11);
define("ACTIVITY_TYPE_CREATE_ANTECEDENT", 12);

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
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_AFFILIATE;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Afiliado', $affiliate);
			$activity->save();
		}
	}

	public static function updateRetirementFund($retirementfund)
	{
		if (Auth::user())
		{   $affiliate = Affiliate::findOrFail($retirementfund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $retirementfund->affiliate_id;
			$activity->retirement_fund_id = $retirementfund->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_RETIREMENT_FUND;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Fondo de Retiro', $affiliate);
			$activity->save();
		}
	}

	public static function createdRetirementFund($retirementfund)
	{
		if (Auth::user())
		{   $affiliate = Affiliate::findOrFail($retirementfund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $retirementfund->affiliate_id;
			$activity->retirement_fund_id = $retirementfund->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_RETIREMENT_FUND;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Fondo de Retiro', $affiliate);
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

	public static function updateDocument($document)
	{
		if (Auth::user())
		{
			$RetirementFund = RetirementFund::findOrFail($document->retirement_fund_id);
		    $affiliate = Affiliate::findOrFail($RetirementFund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $RetirementFund->affiliate_id;
			$activity->document_id = $document->id;
			$activity->retirement_fund_id = $document->retirement_fund_id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_DOCUMENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Documento', $affiliate);
			$activity->save();
		}
	}

	public static function createdDocument($document)
	{
		if (Auth::user())
		{
			$RetirementFund = RetirementFund::findOrFail($document->retirement_fund_id);
		    $affiliate = Affiliate::findOrFail($RetirementFund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $RetirementFund->affiliate_id;
			$activity->document_id = $document->id;
			$activity->retirement_fund_id = $document->retirement_fund_id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_DOCUMENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Documento', $affiliate);
			$activity->save();
		}
	}


	public static function updateAntecedent($antecedent)
	{
		if (Auth::user())
		{
			$RetirementFund = RetirementFund::findOrFail($antecedent->retirement_fund_id);
		    $affiliate = Affiliate::findOrFail($RetirementFund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $RetirementFund->affiliate_id;
			$activity->antecedent_id = $antecedent->id;
			$activity->retirement_fund_id = $RetirementFund->id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_ANTECEDENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Antecedente', $affiliate);
			$activity->save();
		}
	}

	public static function createdAntecedent($antecedent)
	{
		if (Auth::user())
		{
			$RetirementFund = RetirementFund::findOrFail($antecedent->retirement_fund_id);
		    $affiliate = Affiliate::findOrFail($RetirementFund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $RetirementFund->affiliate_id;
			$activity->antecedent_id = $antecedent->id;
			$activity->retirement_fund_id = $antecedent->retirement_fund_id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_ANTECEDENT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Antecedente', $affiliate);
			$activity->save();
		}
	}

	public static function updateSpouse($spouse)
	{
		if (Auth::user())
		{
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $spouse->affiliate_id;
			$activity->spouse_id = $spouse->id;
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
			$activity->affiliate_id = $spouse->affiliate_id;
			$activity->spouse_id = $spouse->id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_SPOUSE;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Conyuge', $spouse);
			$activity->save();
		}
	}

	public static function updateApplicant($applicant)
	{
		if (Auth::user())
		{
			$RetirementFund = RetirementFund::findOrFail($applicant->retirement_fund_id);
		    $affiliate = Affiliate::findOrFail($RetirementFund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $RetirementFund->affiliate_id;
			$activity->applicant_id = $applicant->id;
			$activity->retirement_fund_id = $applicant->retirement_fund_id;
			$activity->activity_type_id = ACTIVITY_TYPE_UPDATE_APPLICANT;
			$activity->message = Util::encodeActivity(Auth::user(), 'actualizó al Solicitante', $applicant);
			$activity->save();
		}
	}

	public static function createdApplicant($applicant)
	{
		if (Auth::user())
		{	$RetirementFund = RetirementFund::findOrFail($applicant->retirement_fund_id);
			$affiliate = Affiliate::findOrFail($RetirementFund->affiliate_id);
			$activity = new Activity;
			$activity->user_id = Auth::user()->id;
			$activity->affiliate_id = $affiliate->id;
			$activity->applicant_id = $applicant->id;
			$activity->retirement_fund_id = $applicant->retirement_fund_id;
			$activity->activity_type_id = ACTIVITY_TYPE_CREATE_APPLICANT;
			$activity->message = Util::encodeActivity(Auth::user(), 'Creó al Solicitante', $applicant);
			$activity->save();
		}
	}


}
