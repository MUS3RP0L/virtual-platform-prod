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

    public function module()
    {
        return $this->belongsTo(EconomicComplementType::class);
    }

    public function scopeTypeidIs($query, $id)
    {
        return $query->where('eco_com_type_id', $id);
    }
}
