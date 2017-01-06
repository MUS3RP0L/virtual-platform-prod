<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

	public function affiliate(){

        return $this->belongsTo('Muserpol\Affiliate');
    }

	public function economic_complement_state(){

        return $this->belongsTo('Muserpol\EconomicComplementState');
    }

    public function economic_complement_modality(){

        return $this->belongsTo('Muserpol\EconomicComplementModality');
    }
    public function city(){

         return $this->belongsTo('Muserpol\City');
     }
    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }
}
