<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementApplicantType extends Model
{
    protected $table = 'eco_com_applicant_types';

	protected $fillable = [

		'name'

	];

	protected $guarded = ['id'];
}
