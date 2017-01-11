<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementApplicantType extends Model
{
    protected $table = 'eco_com_applicant_types';

	protected $fillable = [
		'name'
	];

	protected $guarded = ['id'];

    public function economic_complement_applicants(){
        return $this->hasMany('Muserpol\EconomicComplementApplicant');
    }

    public function scopeIdIs($query, $id){
        return $query->where('id', $id);
    }
}
