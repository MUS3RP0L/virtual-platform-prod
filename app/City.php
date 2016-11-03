<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

	protected $fillable = [
	
		'name',
		'shortened'
	
	];

	protected $guarded = ['id'];

	public function retirement_funds(){

        return $this->hasMany('Muserpol\RetirementFund');
    }

	public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }
}