<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    protected $table = 'units';

	protected $fillable = [
	
		'breakdown_id',
		'district',
		'code',
		'name',
		'shortened'

	];

	protected $guarded = ['id'];

	public function affiliates()
    {
    	return $this->hasMany('Muserpol\Affiliate');
    }

    public function contributions()
    {
    	return $this->hasMany('Muserpol\Contribution');
    }

    public function breakdown()
    {
    	return $this->belongsTo('Muserpol\Breakdown');
    }
}
