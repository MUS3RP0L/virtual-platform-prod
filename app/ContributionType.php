<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ContributionType extends Model
{
    protected $table = 'contribution_types';

	protected $fillable = [
	
		'name'
		
	];

	protected $guarded = ['id'];

}
