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
  		'additional_end_date',
      'rent_month'
  	];

    protected $guarded = ['id'];

    public function economic_complements()
    {
      return $this->hasMany(EconomicComplement::class,'eco_com_procedure_id');
    }

    public function economic_complements_rents()
    {
      return $this->hasMany(EconomicComplementRent::class);
    }

    public function complementary_factors()
    {
      return $this->hasMany(ComplementaryFactor::class);
    }
    
}
