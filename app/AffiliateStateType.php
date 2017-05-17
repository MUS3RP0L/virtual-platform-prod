<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateStateType extends Model
{
    protected $table = 'affiliate_state_types';

	protected $fillable = [

		'name'

	];

	protected $guarded = ['id'];

	public function affiliate_states()
    {
      return $this->hasMany('Muserpol\AffiliateState');
    }

}
