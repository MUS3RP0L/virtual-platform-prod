<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Breakdown extends Model
{
    protected $table = 'breakdowns';

	protected $fillable = [

		'code',
		'name'

	];

	protected $guarded = ['id'];
	public $timestamps=false;

	public function units()
    {
        return $this->hasMany('Muserpol\Unit');
    }
}
