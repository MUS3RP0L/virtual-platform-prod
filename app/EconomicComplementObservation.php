<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EconomicComplementObservation extends Model
{
    use SoftDeletes;
    //
    protected $table = 'eco_com_observations';

    public function economic_complement()
    {
        return $this->belongsTo('Muserpol\EconomicComplement');
    }
    public function observationType()
	{
		return $this->belongsTo(ObservationType::class);
	}
}
