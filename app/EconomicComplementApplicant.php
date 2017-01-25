<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

use Muserpol\Helper\Util;
use Carbon\Carbon;

class EconomicComplementApplicant extends Model
{
    protected $table = 'eco_com_applicants';

    protected $fillable = [

      'economic_complement_id',
      'eco_com_applicant_type_id',
      'city_identity_card_id',
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

    public function economic_complement()
    {
        return $this->belongsTo('Muserpol\EconomicComplement');
    }

    public function economic_complement_applicant_type()
    {
        return $this->belongsTo('Muserpol\EconomicComplementApplicantType');
    }

    public function city_identity_card()
    {
        return $this->belongsTo('Muserpol\City','city_identity_card_id');
    }

    public function scopeEconomicComplementIs($query, $id)
    {
        return $query->where('economic_complement_id', $id);
    }

    public function getEditBirthDate()
    {
        return Util::getDateEdit($this->birth_date);
    }
    public function getTitleNameFull()
    {
        return $this->last_name . ' ' . $this->mothers_last_name . ' ' . $this->surname_husband . ' ' . $this->first_name . ' ' . $this->second_name;
    }

    public function getPhone()
    {
        if($this->phone_number && $this->cell_phone_number) {
            return $this->phone_number." - ".$this->cell_phone_number;
        }
        else if($this->phone_number) {
            return $this->phone_number;
        }
        else if($this->cell_phone_number) {
            return $this->cell_phone_number;
        }
    }

    public function getShortBirthDate()
    {
        return Util::getDateShort($this->birth_date);
    }

    public function getHowOld()
    {
        if ($this->date_death) {
            return Util::getHowOldF($this->birth_date, $this->date_death) . " AÑOS";
        }
        else{
            return Carbon::parse($this->birth_date)->age . " AÑOS";
        }
    }

    public function getTittleName()
    {
        return Util::ucw($this->first_name) . ' ' . Util::ucw($this->second_name)  . ' ' . Util::ucw($this->last_name) . ' ' . Util::ucw($this->mothers_last_name) . ' ' . Util::ucw($this->surname_husband);
    }

    public function getCivilStatus()
    {
        if ($this->civil_status == 'S') {

            if ($this->gender == 'M') {
                return "SOLTERO";
            }
            else{
                return "SOLTERA";
            }
        }
        else if ($this->civil_status == 'C') {
            if ($this->gender == 'M') {
                return "CASADO";
            }
            else{
                return "CASADA";
            }
        }
        else if ($this->civil_status == 'V') {
            if ($this->gender == 'M') {
                return "VIUDO";
            }
            else{
                return "VIUDA";
            }
        }
        else if ($this->civil_status == 'D') {
            if ($this->gender == 'M') {
                return "DIVORCIADO";
            }
            else{
                return "DIVORCIADA";
            }
        }
    }

}

EconomicComplementApplicant::created(function($ec_applicant)
{
    Activity::createdEconomicComplementApplicant($ec_applicant);

});

EconomicComplementApplicant::updated(function($ec_applicant)
{
    Activity::updateEconomicComplementApplicant($ec_applicant);

});
