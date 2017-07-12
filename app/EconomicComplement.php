<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Muserpol\Helper\Util;

class EconomicComplement extends Model
{
    use SoftDeletes;

    protected $table = 'economic_complements';

    protected $dates = ['deleted_at'];

	protected $fillable = [
        'user_id',
        'affiliate_id',
    	'eco_com_modality_id',
    	'wf_current_state_id',
        'city_id',
        'category_id',
        'base_wage_id',
        'complementary_factor_id',
        'has_legal_guardian',
        'code',
        'reception_date',
        'review_date',
        'year',
        'semester',
        'sub_total_rent',
        'reimbursement_basic_pension',
        'dignity_pension',
        'dignity_pension_reimbursement',
        'dignity_pension_bonus',
        'bonus_reimbursement',
        'reimbursement_aditional_amount',
        'reimbursement_increase_year',
        'total_rent',
        'total_rent_calc',
        'salary_reference',
        'seniority',
        'salary_quotable',
        'difference',
        'total_amount_semester',
        'complementary_factor',
        'reimbursement',
        'christmas_bonus',
        'quotable',
        'total',
        'payment_date',
        'payment_number',
        'comment',
        'eco_com_procedure_id'
	];

	protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Muserpol\User');
    }
	public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }

	public function economic_complement_modality()
    {
        return $this->belongsTo('Muserpol\EconomicComplementModality', 'eco_com_modality_id');
    }

    public function city()
    {
        return $this->belongsTo('Muserpol\City');
    }

    public function category()
    {
        return $this->belongsTo('Muserpol\Category');
    }

    public function base_wage()
    {
        return $this->belongsTo('Muserpol\BaseWage');
    }

    public function complementary_factor()
    {
        return $this->belongsTo('Muserpol\ComplementaryFactor');
    }

    public function economic_complement_submitted_documents()
    {
        return $this->hasMany('Muserpol\EconomicComplementSubmittedDocument');
    }

    public function economic_complement_applicant()
    {
        return $this->hasOne('Muserpol\EconomicComplementApplicant');
    }
    public function economic_complement_legal_guardian()
    {
        return $this->hasOne('Muserpol\EconomicComplementLegalGuardian');
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeAffiliateIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
    }

    public function getCreationDate()
    {
        return Util::getDateShort($this->reception_date);
    }

    public function getCode()
    {
        return "Proceso N° " . $this->code;
    }
    public function economic_complement_procedure()
    {
        return $this->belongsTo(EconomicComplementProcedure::class);
    }
    public function economic_complement_state()
    {
        return $this->belongsTo(EconomicComplementState::class);
    }
    public function workflow()
    {
        return $this->belongsTo('Muserpol\Workflow');
    }
    public function wf_state()
    {
        return $this->belongsTo('Muserpol\WorkflowState','wf_current_state_id');
    }

    public function getYear()
    {
        if($this->year){
            return Util::getYear($this->year);
        }
    }

}

EconomicComplement::created(function($ecomplement)
{
    Activity::createdEconomicComplement($ecomplement);
});

EconomicComplement::updated(function($ecomplement)
{
    Activity::updateEconomicComplement($ecomplement);

});
