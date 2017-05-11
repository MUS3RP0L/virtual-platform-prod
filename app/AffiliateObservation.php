<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateObservation extends Model
{
	protected $table = 'affiliate_observations';
	protected $fillable = [

        'user_id',
		'affiliate_id',
		'module_id',
		'date',
		'title',
		'description'

	];
	protected $guarded = ['id'];
	public function affiliate()
	{
		return $this->belongsTo(Affiliate::class);
	}
	public function module()
	{
		return $this->belongsTo(Module::class);
	}

}
