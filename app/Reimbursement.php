<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Reimbursement extends Model
{
    protected $table = 'reimbursements';

	protected $fillable = [

		'user_id',
		'affiliate_id',
		'direct_contribution_id',
		'month_year',
		'base_wage',
		'seniority_bonus',
		'study_bonus',
		'position_bonus',
		'border_bonus',
		'east_bonus',
		'public_security_bonus',
		'gain',
		'payable_liquid',
		'quotable',
		'retirement_fund',
		'mortuary_quota',
		'mortuary_aid',
		'subtotal',
		'ipc',
		'total'
	];

	protected $guarded = ['id'];

}
