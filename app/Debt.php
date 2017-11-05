<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    public function observation_type()
    {
    	return $this->belongsTo(ObservationType::class);
    }
}
