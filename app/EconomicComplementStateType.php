<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementStateType extends Model
{	
	protected $table = 'eco_com_state_types';
    protected $fillable = [
  		'name'
  	];

    protected $guarded = ['id'];
    public $timestamps=false;
    public function economic_complement_states()
    {
    	return $this->hasMany(EconomicComplementState::class);
    }
}
