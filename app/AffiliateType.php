<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateType extends Model
{
    protected $table = 'affiliate_types';

	protected $fillable = [

		'name'

	];

	protected $guarded = ['id'];

	public function affiliates()
    {
    	return $this->hasMany('Muserpol\Affiliate');
    }
}
