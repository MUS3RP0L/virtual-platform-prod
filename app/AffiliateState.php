<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateState extends Model
{
    protected $table = 'affiliate_states';

	protected $fillable = [
	
		'state_type_id',
		'name'
	
	];

	protected $guarded = ['id'];

    public function state_type()
    {
    	return $this->belongsTo('Muserpol\StateType');
    }

    public function affiliates()
    {
    	return $this->hasMany('Muserpol\Affiliate');
    }
}
