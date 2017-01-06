<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementModality extends Model
{
    protected $table = 'eco_com_modalities';

	protected $fillable = [

		'eco_com_type_id',
		'name',
		'description'
	];

	protected $guarded = ['id'];

	public function economic_complements(){

        return $this->hasMany('Muserpol\EconomicComplement');
    }

    public function economic_complement_type(){

         return $this->belongsTo('Muserpol\EconomicComplementType');
     }

    public function scopeTypeidIs($query, $id)
    {
        return $query->where('eco_com_type_id', $id);
    }

    public function scopeNameIs($query, $id)
    {
        return $query->where('name', $id);
    }
}
