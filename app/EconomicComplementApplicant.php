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
        'city_identity_card_id',
        'identity_card',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'surname_husband',
        'birth_date',
        'nua',
        'gender',
        'civil_status',
        'phone_number',
        'cell_phone_number',

    ];

    protected $guarded = ['id'];

    public function economic_complement()
    {
        return $this->belongsTo('Muserpol\EconomicComplement');
    }

    public function economic_complement_legal_guardian()
    {
        return $this->hasOne('Muserpol\EconomicComplementLegalGuardian', 'eco_com_applicant_id');
    }
    public function scopeIdentitycardIs($query, $ci)
    {
        return $query->where('identity_card', $ci);
    }

    public function city_identity_card()
    {
        return $this->belongsTo('Muserpol\City','city_identity_card_id');
    }
    public function city_birth()
    {
        return $this->hasOne('Muserpol\City', 'id','city_birth_id');
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

    public function getShortDateDeath()
    {
        return Util::getDateShort($this->date_death);
    }

    public function getPhone()
    {
        if($this->phone_number && $this->cell_phone_number) {
            $phone_number = explode(",", $this->phone_number);
            $cell_phone_number = explode(",", $this->cell_phone_number);
            $phone_number = $phone_number[0];
            $cell_phone_number = $cell_phone_number[0];
            return $phone_number." - ".$cell_phone_number;
        }
        else if($this->phone_number) {
            $phone_number = explode(",", $this->phone_number);
            $phone_number = $phone_number[0];
            return $phone_number;
        }
        else if($this->cell_phone_number) {
            $cell_phone_number = explode(",", $this->cell_phone_number);
            $cell_phone_number = $cell_phone_number[0];
            return $cell_phone_number;
        }
    }

    public function getShortBirthDate()
    {
        return Util::getDateShort($this->birth_date);
    }

    public function getAge()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function getTittleName()
    {
        return Util::ucw($this->first_name) . ' ' . Util::ucw($this->second_name)  . ' ' . Util::ucw($this->last_name) . ' ' . Util::ucw($this->mothers_last_name) . ' ' . Util::ucw($this->surname_husband);
    }
    public function getFullName()
    {
        $name = ($this->first_name)." ".($this->second_name)." ".($this->last_name)." ".($this->mothers_last_name)." ".($this->surname_husband);
        $re = '/\s+/';
        $subst = ' ';
        $result = preg_replace($re, $subst, $name);
        
        return trim($result);
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
    public function getGender()
    {
        if ($this->gender == 'M') {
            return "MASCULINO";
        }
        else if ($this->gender == 'F') {
            return "FEMENINO";
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
