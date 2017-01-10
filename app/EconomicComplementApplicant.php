<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementApplicant extends Model
{
    protected $table = 'eco_com_applicants';

    protected $fillable = [
      'economic_complement_id',
      'eco_com_applicant_type_id',
      'identity_card',
      'last_name',
      'mothers_last_name',
      'first_name',
      'kinship',
      'home_address',
      'home_phone_number',
      'home_cell_phone_number',
      'work_address'
    ];

    protected $guarded = ['id'];

    public function economic_complement(){

        return $this->belongsTo('Muserpol\EconomicComplement');
    }

    public function economic_complement_applicant_type(){

        return $this->belongsTo('Muserpol\EconomicComplementApplicantType');
    }

    public function scopeEconomicComplementIs($query, $id)
    {
        return $query->where('economic_complement_id', $id);
    }


}
