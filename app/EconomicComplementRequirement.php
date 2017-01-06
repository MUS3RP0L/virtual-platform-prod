<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementRequirement extends Model
{
  protected $table = 'eco_com_requirements';

  protected $fillable = [
    'eco_com_type_id',
    'name',
    'shortened'
  ];
  protected $guarded = ['id'];
}
