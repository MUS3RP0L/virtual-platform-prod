<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use Muserpol\Helper\Util;
use DB;

class RetirementFund extends Model
{
    use SoftDeletes;

    protected $table = 'retirement_funds';

    protected $dates = ['deleted_at'];

	protected $fillable = [

		'affiliate_id',
		'retirement_fund_modality_id',
		'city_id',
        'code',
        'reception_date',
        'check_file_date',
        'qualification_date',
        'legal_assessment_date',
        'anticipation_start_date',
        'anticipation_end_date',
        'recognized_start_date',
        'recognized_end_date',
        'total_quotable',
        'total_additional_quotable',
        'subtotal',
        'performance',
        'total',
        'comment'

	];

	protected $guarded = ['id'];

	public function affiliate(){

        return $this->belongsTo('Muserpol\Affiliate');
    }

	public function retirement_fund_modality(){

        return $this->belongsTo('Muserpol\RetirementFundModality');
    }

    public function city(){

        return $this->belongsTo('Muserpol\City');
    }

    public function documents(){

        return $this->hasMany('Muserpol\Document');
    }

    public function antecedents(){

        return $this->hasMany('Muserpol\Antecedent');
    }

    public function applicants()
    {
        return $this->hasMany('Muserpol\Applicant');
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id)->where('deleted_at', '=', null)->orderBy('id', 'desc');
    }

    public function scopeAfiIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
    }
    public function scopeTotalRetirementFund($query, $month, $year)
    {
       return $query = DB::table('retirement_funds')
                    ->select(DB::raw('COUNT(*) total, month(retirement_funds.reception_date) as month'))
                    ->whereMonth('retirement_funds.reception_date', '=', $month)
                    ->whereYear('retirement_funds.reception_date', '=', $year);
    }

    public function getFull_fech_ini_anti()
    {
        return Util::getdateabreperiod($this->fech_ini_anti);
    }
    public function getFull_fech_fin_anti()
    {
        return Util::getdateabreperiod($this->fech_fin_anti);
    }
    public function getYearsAndMonths_fech_ini_anti()
    {
        return Util::getYearsAndMonths($this->fech_ini_anti, $this->fech_fin_anti);
    }

    public function getFull_fech_ini_reco()
    {
        return Util::getdateabreperiod($this->fech_ini_reco);
    }
    public function getFull_fech_fin_reco()
    {
        return Util::getdateabreperiod($this->fech_fin_reco);
    }
    public function getYearsAndMonths_fech_ini_reco()
    {
        return Util::getYearsAndMonths($this->fech_ini_reco, $this->fech_fin_reco);
    }

    public function getNumberTram()
    {
        if ($this->code) {
            return $this->code . "/" . Carbon::parse($this->created_at)->year;
        }
    }

    public function getStatus()
    {
        if ($this->fech_ven && $this->fech_arc && $this->fech_cal && $this->fech_dic ) {
            return "FINALIZADO";
        }elseif ($this->fech_ven && $this->fech_arc && $this->fech_cal) {
            return "DICTAMEN LEGAL";
        }elseif ($this->fech_ven && $this->fech_arc) {
            return "CALIFICACIÓN";
        }elseif ($this->fech_ven) {
            return "ARCHIVO";
        }else {
            return "VENTANILLA";
        }
    }


}

RetirementFund::created(function($retirementfund)
{
    Activity::createdRetirementFund($retirementfund);

});

RetirementFund::updating(function($retirementfund)
{
    Activity::updateRetirementFund($retirementfund);

});
