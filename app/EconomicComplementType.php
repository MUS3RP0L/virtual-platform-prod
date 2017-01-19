<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementType extends Model
{
    protected $table = 'eco_com_types';

	protected $fillable = [

		'name'
        
	];

	protected $guarded = ['id'];

	public function economic_complement_modalities()
    {
        return $this->hasMany('Muserpol\EconomicComplementModality');
    }
    public function economic_complement_rents()
    {
        return $this->hasMany('Muserpol\EconomicComplementRent');
    }

    public function economic_complement_requirements()
    {
        return $this->hasMany('Muserpol\EconomicComplementRequirement');
    }

}
