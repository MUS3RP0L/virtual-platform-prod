<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ObservationType extends Model
{
    protected $table = 'observation_types';

	protected $fillable = [
		'observation_state_id',
        'module_id',
        'type',
        'observation',
        'enable1',
        'enable2',
        'pending'
	];
    protected $guarded = ['id'];

    public function observation_records()
    {
        return $this->hasMany(ObservationRecord::class);
    }
}
