<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

	protected $fillable = [
	
		'from',
		'to',
		'name',
		'percentage'
		
	];

	protected $guarded = ['id'];

	public function affiliates()
    {
    	return $this->hasMany('Muserpol\Affiliate');
    }

    public function contribtions()
    {
    	return $this->hasMany('Muserpol\Contribution');
    }
}
