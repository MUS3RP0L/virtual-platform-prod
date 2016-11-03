<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class RetirementFundModality extends Model
{
    protected $table = 'retirement_fund_modalities';

	protected $fillable = [
	
		'name',
		'shortened'
	];

	protected $guarded = ['id'];

	public function retirement_funds(){

        return $this->hasMany('Muserpol\RetirementFund');
    }

    public function requirements(){

        return $this->hasMany('Muserpol\Requirement');
    }

}
