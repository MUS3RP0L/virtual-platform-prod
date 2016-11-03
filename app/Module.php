<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

	protected $fillable = [

		'name'
	];

	protected $guarded = ['id'];

}
