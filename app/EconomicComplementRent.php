<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementRent extends Model
{
    protected $table = 'eco_com_rents';

	protected $fillable = [

		'name',
		'description',
		'shortened'
	];

	protected $guarded = ['id'];

	public function economic_complements(){

        return $this->hasMany('Muserpol\EconomicComplement');
    }
}
