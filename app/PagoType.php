<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class PagoType extends Model
{
    protected $table = 'pago_types';

	protected $fillable = [
	
		'name'
		
	];

	protected $guarded = ['id'];

}
