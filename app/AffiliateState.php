<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateState extends Model
{
    protected $table = 'affiliate_states';

	protected $fillable = [

        'affiliate_state_type_id',
		'name'

	];

	protected $guarded = ['id'];
    public $timestamps=false;
    public function affiliate_state_type()
    {
    	return $this->belongsTo('Muserpol\AffiliateStateType');
    }

    public function affiliates()
    {
    	return $this->hasMany('Muserpol\Affiliate');
    }
}
