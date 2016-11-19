<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Hierarchy extends Model
{
    protected $table = 'hierarchies';

	protected $fillable = [

		'code',
		'name'

	];

	protected $guarded = ['id'];
}
