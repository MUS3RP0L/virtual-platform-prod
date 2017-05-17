<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementRent extends Model
{
    protected $table = 'eco_com_rents';

	protected $fillable = [
        'user_id',
		'degree_id',
		'eco_com_type_id',
		'year',
        'semester',
        'minor',
        'higher',
        'average',
        'user_id'       
	];

    protected $guarded = ['id'];

    public function degree()
    {
      return $this->belongsTo('Muserpol\Degree');
    }

    public function economic_complement_type()
    {
      return $this->belongsTo('Muserpol\EconomicComplementType');
    }

}
