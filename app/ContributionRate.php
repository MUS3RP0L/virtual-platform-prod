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
    	'retirement_fund_commission',
        'mortuary_quota_commission',
		'mortuary_aid',
		'user_id'

	];

	protected $guarded = ['id'];
}
