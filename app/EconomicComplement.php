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

        'affiliate_id',
		'eco_com_modality_id',
		'eco_com_state_id',
        'city_id',
        'category_id',
        'base_wage_id',
        'complementary_factor_id',
        'first_ticket_month_id',
        'second_ticket_month_id',
        'code',
        'reception_date',
        'review_date',
        'semester',
        'sub_total_rent',
        'dignity_pension',
        'reimbursement',
        'christmas_bonus',
        'seniority',
        'quotable',
        'total'

	];

	protected $guarded = ['id'];

	public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }

	public function economic_complement_state()
    {
        return $this->belongsTo('Muserpol\EconomicComplementState', 'eco_com_state_id');
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
        return Util::getDateShort($this->created_at);
    }

    public function getCode()
    {
        return "Proceso N° " . $this->code;
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
