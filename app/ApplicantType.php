<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ApplicantType extends Model
{
    protected $table = 'applicant_types';

	protected $fillable = [
	
		'name'
		
	];

	protected $guarded = ['id'];
 
}
