<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementModality extends Model
{
    protected $table = 'eco_com_modalities';

	protected $fillable = [

		'name',
		'description'
	];

	protected $guarded = ['id'];

	public function economic_complements(){

        return $this->hasMany('Muserpol\EconomicComplement');
    }
}
