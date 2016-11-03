<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class StateType extends Model
{
    protected $table = 'state_types';

	protected $fillable = [
	
		'name'
		
	];

	protected $guarded = ['id'];

	public function affiliate_states()
    {
        return $this->hasMany('Muserpol\AffiliateState');
    } 
}
