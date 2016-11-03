<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class BaseWage extends Model
{
    protected $table = 'base_wages';

	protected $fillable = [
		
		'user_id',
		'degree_id',
		'month_year',
		'amount'
	];

	protected $guarded = ['id'];

	public function degree()
    {
        return $this->belongsTo('Muserpol\Degree');
    }
}
