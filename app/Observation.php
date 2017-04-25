<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
	public function affiliate()
	{
		return $this->belongsT(Affiliate::class);
	}
}
