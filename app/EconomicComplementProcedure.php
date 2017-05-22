<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementProcedure extends Model
{
    protected $table = 'eco_com_procedures';
    
    protected $fillable = [
  		'year',
  		'semester',
  		'normal_start_date',
  		'normal_end_date',
  		'lagging_start_date',
  		'lagging_end_date',
  		'additional_start_date',
  		'additional_end_date'
  	];

    protected $guarded = ['id'];

}
