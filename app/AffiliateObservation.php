<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AffiliateObservation extends Model
{
	use SoftDeletes;
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

	public function observationType()
	{
		return $this->belongsTo(ObservationType::class);
	}
	
}
