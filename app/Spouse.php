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
        'identity_card',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'birth_date',
        'date_death',
        'reason_death'
    ];

    protected $guarded = ['id'];

    public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }

    public function scopeAffiliateidIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
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
        return Util::getDateEdit($this->birth_date);
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

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->mothers_last_name. ' ' . $this->first_name. ' ' .$this->second_name;
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
