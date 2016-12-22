<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ComplementarityFactor extends Model
{
    protected $table = 'complementarity_factors';

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
