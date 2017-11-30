<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    public function devolution()
    {
    	return $this->belongsTo(Devolution::class);
    }
}
