<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ContributionRate extends Model
{
    protected $table = 'contribution_rates';

	protected $fillable = [
	
		'month_year',
		'retirement_fund',
        'mortuary_quota',
        'rate_active',
        'mortuary_aid'
	];

	protected $guarded = ['id'];
}
