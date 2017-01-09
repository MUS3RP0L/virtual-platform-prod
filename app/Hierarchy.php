<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Hierarchy extends Model
{
  protected $table = 'hierarchies';

	protected $fillable = [

		'code',
		'name'

	];

	protected $guarded = ['id'];

  public function degrees(){
    return $this->hasMany('Muserpol\Degree');
  }

  public function complementary_factors(){
    return $this->hasMany('Muserpol\ComplementaryFactor');
  }

}
