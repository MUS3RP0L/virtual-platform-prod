<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AntecedentFile extends Model
{
    protected $table = 'antecedent_files';

	protected $fillable = [
	
		'name',
		'shortened'
	];

	protected $guarded = ['id'];

	public function antecedents(){

        return $this->hasMany('Muserpol\Antecedent');
    }
}
