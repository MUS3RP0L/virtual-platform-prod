<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class ObservationRecord extends Model
{
    protected $table = 'observation_records';

	protected $fillable = [
		'user_id',
        'affiliate_id',
        'observation_type_id',
        'observation_state_id',
        'date',
        'description',
        'pending'
	];
    protected $guarded = ['id'];

    public function observation_state()
    {
        return $this->belongsTo(ObservationState::class);
    }
    public function observation_type()
    {
        return $this->belongsTo(ObservationType::class);
    }

}
