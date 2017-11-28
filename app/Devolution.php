<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Devolution extends Model
{
    public function observation_type()
    {
    	return $this->belongsTo(ObservationType::class);
    }
}
