<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementLegalGuardian extends Model
{
    protected $table = 'eco_com_legal_guardians';

    protected $fillable = [

        'economic_complement_id',
        'city_identity_card_id',
        'identity_card',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'surname_husband',
        'phone_number',
        'cell_phone_number'

    ];

    protected $guarded = ['id'];

    public function economic_complement_applicant()
    {
        return $this->belongsTo('Muserpol\EconomicComplementApplicant');
    }

    public function city_identity_card()
    {
        return $this->belongsTo('Muserpol\City','city_identity_card_id');
    }

    public function scopeEconomicComplementIs($query, $id)
    {
        return $query->where('economic_complement_id', $id);
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

    public function getTittleName()
    {
        return Util::ucw($this->first_name) . ' ' . Util::ucw($this->second_name)  . ' ' . Util::ucw($this->last_name) . ' ' . Util::ucw($this->mothers_last_name) . ' ' . Util::ucw($this->surname_husband);
    }
}
