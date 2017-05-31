<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateObservation extends Model
{
	protected $table = 'affiliate_observations';
	protected $fillable = [

        'user_id',
		'affiliate_id',
		'observation_type_id',
		'date',
		'message'

	];
	protected $guarded = ['id'];
	public function affiliate()
	{
		return $this->belongsTo(Affiliate::class);
	}

	public function observationsType()
	{
		return $this->belongsTo(ObservationType::class);
	}
	
}
