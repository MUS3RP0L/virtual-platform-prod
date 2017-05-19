<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementState extends Model
{
    protected $table = 'eco_com_states';
    protected $fillable = [
  		   'eco_com_state_type_id',
            'name'
  	];

    protected $guarded = ['id'];
    public $timestamps=false;
}
