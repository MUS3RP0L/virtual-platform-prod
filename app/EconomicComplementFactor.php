<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementFactor extends Model
{
    protected $table = 'eco_com_factors';

	protected $fillable = [

		'hierarchy_id',
		'year',
		'semester',
		'old_age',
		'widowhood'
	];

	protected $guarded = ['id'];

	public function economic_complements(){

        return $this->hasMany('Muserpol\EconomicComplement');
    }
}
