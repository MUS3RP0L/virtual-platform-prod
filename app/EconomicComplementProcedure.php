<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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
    public function getShortenedName()
    {
      $s=($this->semester == 'Primer') ?'1ER. SEMESTRE/':'2DO. SEMESTRE/';
      $y=Carbon::parse($this->year)->year;
      return  $s.''.$y;
    }
    public function getShortenedNameTwo()
    {
      $s=($this->semester == 'Primer') ?'1ER. SEMESTRE':'2DO. SEMESTRE';
      $y=Carbon::parse($this->year)->year;
      return  $s.' '.$y;
    }
    public function getFullName()
    {
      $s=($this->semester == 'Primer') ?'PRIMER':'SEGUNDO';
      $y=Carbon::parse($this->year)->year;
      return  $s.' SEMESTRE '.$y;
    }
}
