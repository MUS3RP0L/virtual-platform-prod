<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementComplementarityFactor extends Model
{
    protected $table = 'eco_com_complementarity_factors';

	protected $fillable = [

		'month_year',
		'old_age',
		'widowhood'
	];

	protected $guarded = ['id'];

	public function economic_complements(){

        return $this->hasMany('Muserpol\EconomicComplement');
    }
}
