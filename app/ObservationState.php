<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ObservationState extends Model
{
    protected $table = 'observation_states';

	protected $fillable = [
		'name',
	];
    protected $guarded = ['id'];

    public function observation_records()
    {
        return $this->hasMany(ObservationRecord::class);
    }


}
