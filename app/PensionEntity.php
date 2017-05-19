<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class PensionEntity extends Model
{
    protected $table = 'pension_entities';

	protected $fillable = [

		'type',
		'name'

	];

	protected $guarded = ['id'];
	public $timestamps=false;
	public function affiliates()
    {
    	return $this->hasMany('Muserpol\Affiliate');
    }

}
