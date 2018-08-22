<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Muserpol\Helper\Util;

class Spouse extends Model
{
    protected $table = 'spouses';

    protected $dates = ['deleted_at'];

    protected $fillable = [

        'user_id',
        'affiliate_id',
        'city_identity_card_id',
        'identity_card',
        'registration',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'surname_husband',
        'civil_status',
        'birth_date',
        'city_birth_id',
        'date_death',
        'reason_death'
        

    ];

    protected $guarded = ['id'];

    public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }
    public function city()
    {
        return $this->belongsTo('Muserpol\City');
    }

    public function scopeAffiliateidIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
    }
    public function scopeIdentitycardIs($query, $ci)
    {
        return $query->where('identity_card', $ci);
    }
    public function getShortBirthDate()
    {
        return Util::getDateShort($this->birth_date);
    }

    public function getShortDateDeath()
    {
        return Util::getDateShort($this->date_death);
    }

    public function getEditBirthDate()
    {
        return Util::getDateEdit($this->birth_date);
    }
    public function getEditDateDeath()
    {
        return Util::getDateEdit($this->date_death);
    }

    public function getFullNametoPrint()
    {
        return $this->fisrt_name . ' ' . $this->second_name . ' ' . $this->last_name. ' ' . $this->mothers_last_name;
    }

    public function getFullDateNactoPrint()
    {
        if ($this->birth_date) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            return date("d", strtotime($this->birth_date))." de ".$meses[date("m", strtotime($this->birth_date))-1]. " de ".date("Y", strtotime($this->fech_nac));
        }
    }
    public function getFull_fech_decetoPrint()
    {
        if ($this->date_death) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            return date("d", strtotime($this->date_death))." ".$meses[date("n", strtotime($this->date_death))-1]. " ".date("Y", strtotime($this->date_death));
        }
    }
    public function getShortDueDate()
    {
        return Util::getDateShort($this->due_date);
    }
    public function getFullName()
    {
        $name = ($this->first_name)." ".($this->second_name)." ".($this->last_name)." ".($this->mothers_last_name)." ".($this->surname_husband);
        $re = '/\s+/';
        $subst = ' ';
        $result = preg_replace($re, $subst, $name);
        if ($result) {
            return trim($result);
        }
        return null;
    }

    public function city_birth()
    {
        return $this->hasOne('Muserpol\City', 'id','city_birth_id');
    }

    public function getCivilStatus()
    {
        if ($this->civil_status == 'S') {

                return "SOLTERO(A)";

        }
        else if ($this->civil_status == 'C') {

                return "CASADO(A)";

        }
        else if ($this->civil_status == 'V') {

                return "VIUDO(A)";

        }
        else if ($this->civil_status == 'D'){

                return "DIVORCIADO(A)";

        }
    }
}

Spouse::created(function($spouse)
{
    Activity::createdSpouse($spouse);
});

Spouse::updating(function($spouse)
{
    Activity::updateSpouse($spouse);

});
