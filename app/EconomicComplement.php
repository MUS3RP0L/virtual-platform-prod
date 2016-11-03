<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplement extends Model
{
    use SoftDeletes;

    protected $table = 'economic_complements';

    protected $dates = ['deleted_at'];

	protected $fillable = [

        'affiliate_id',
		'retirement_fund_modality_id',
		'city_id',
        'code',
        'reception_date',
        'review_date'

        // 'total_quotable',
        // 'total_additional_quotable',
        // 'subtotal',
        // 'performance',
        // 'total',
        // 'comment'

	];

	protected $guarded = ['id'];

	public function affiliate(){

        return $this->belongsTo('Muserpol\Affiliate');
    }

	public function economic_complement_modality(){

        return $this->belongsTo('Muserpol\EconomicComplementModality');
    }
}
