<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use Muserpol\Helper\Util;
use DB;

class Affiliate extends Model
{
    use SoftDeletes;

    protected $table = 'affiliates';

    protected $dates = ['deleted_at'];

    protected $fillable = [

        'user_id',
        'affiliate_state_id',
        'city_identity_card_id',
        'city_birth_id',
        'degree_id',
        'unit_id',
        'category_id',
        'pension_entity_id',
        'identity_card',
        'registration',
        'type',
        'last_name',
        'mothers_last_name',
        'first_name',
        'second_name',
        'surname_husband',
        'civil_status',
        'gender',
        'birth_date',
        'date_entry',
        'date_death',
        'reason_death',
        'date_derelict',
        'reason_derelict',
        'change_date',
        'phone_number',
        'cell_phone_number',
        'afp',
        'nua',
        'item'
    ];

    protected $guarded = ['id'];

    public function contributions()
    {
        return $this->hasMany('Muserpol\Contribution');
    }

    public function records()
    {
        return $this->hasMany('Muserpol\AffiliateRecord');
    }

    public function spouse()
    {
        return $this->hasOne('Muserpol\Spouse');
    }

    public function user()
    {
        return $this->belongsTo('Muserpol\User');
    }

    public function degree(){

        return $this->belongsTo('Muserpol\Degree');
    }

    public function category(){

        return $this->belongsTo('Muserpol\Category');
    }

    public function unit(){

        return $this->belongsTo('Muserpol\Unit');
    }

    public function affiliate_state()
    {
        return $this->belongsTo('Muserpol\AffiliateState');
    }

    public function city_identity_card()
    {
        return $this->hasOne('Muserpol\City', 'id','city_identity_card_id');
    }

    public function city_birth()
    {
        return $this->hasOne('Muserpol\City', 'id','city_birth_id');
    }

    public function reimbursements()
    {
        return $this->hasMany('Muserpol\Reimbursement');
    }
    public function affiliate_address()
    {
        return $this->hasMany('Muserpol\AffiliateAddress');
    }
    public function economic_complements()
    {
        return $this->hasMany('Muserpol\EconomicComplement');
    }

    public function pension_entity()
    {
        return $this->belongsTo('Muserpol\PensionEntity');
    }
    public function observations()
    {
        return $this->hasMany(AffiliateObservation::class);
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeIdentitycardIs($query, $ci)
    {
        return $query->where('identity_card', $ci);
    }

    public function getTittleName()
    {
        return Util::ucw($this->last_name) . ' ' . Util::ucw($this->mothers_last_name) . ' ' . Util::ucw($this->surname_husband) . ' ' . Util::ucw($this->first_name) . ' ' . Util::ucw($this->second_name);
    }
    public function getTittleNamePrint()
    {
        return $this->degree->shortened . ' ' . $this->last_name . ' ' . $this->mothers_last_name . ' ' . $this->surname_husband . ' ' . $this->first_name . ' ' . $this->second_name;
    }

    public function getTitleNameFull()
    {
        return $this->last_name . ' ' . $this->mothers_last_name . ' ' . $this->surname_husband . ' ' . $this->first_name . ' ' . $this->second_name;
    }

    public function getShortBirthDate()
    {
        return Util::getDateShort($this->birth_date);
    }

    public function getShortDateDeath()
    {
        return Util::getDateShort($this->date_death);
    }

    public function getShortDateEntry()
    {
        return Util::getDateShort($this->date_entry);
    }

    public function getAge()
    {
        return Carbon::parse($this->birth_date)->age;
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
    public function getSpouseGender()
    {
        if ($this->gender == 'F') {
            return "MASCULINO";
        }
        else if ($this->gender == 'M') {
            return "FEMENINO";
        }
    }

    public function getPhone()
    {
        if($this->phone_number && $this->cell_phone_number) {
            return $this->phone_number."-".$this->cell_phone_number;
        }
        else if($this->phone_number) {
            return $this->phone_number;
        }
        else if($this->cell_phone_number) {
            return $this->cell_phone_number;
        }
    }

    public function getCivilStatus()
    {
        if ($this->civil_status == 'S') {

            if ($this->gender == 'M') {
                return "SOLTERO";
            }
            else {
                return "SOLTERA";
            }
        }
        else if ($this->civil_status == 'C') {
            if ($this->gender == 'M') {
                return "CASADO";
            }
            else {
                return "CASADA";
            }
        }
        else if ($this->civil_status == 'V') {
            if ($this->gender == 'M') {
                return "VIUDO";
            }
            else {
                return "VIUDA";
            }
        }
        else if ($this->civil_status == 'D'){
            if ($this->gender == 'M') {
                return "DIVORCIADO";
            }
            else {
                return "DIVORCIADA";
            }
        }
    }

    public function getEditDateDecommissioned()
    {
        return Util::getDateEdit($this->date_decommissioned);
    }

    public function getEditBirthDate()
    {
        return Util::getDateEdit($this->birth_date);
    }
    public function getEditDateEntry()
    {
        return Util::getDateEdit($this->date_entry);
    }
    public function getEditDateDeath()
    {
        return Util::getDateEdit($this->date_death);
    }

    public function scopeAfibyState($query, $state, $year)
    {
       return $query = DB::table('affiliates')
                    ->select(DB::raw('COUNT(*) as total'))
                    ->where('affiliates.affiliate_state_id', '=', $state)
                    ->whereYear('affiliates.updated_at', '=', $year);
    }

    public function scopeAfibyType($query, $type, $year)
    {
       return $query = DB::table('affiliates')
                    ->select(DB::raw('COUNT(*) as type'))
                    ->where('affiliates.type', '=', $type)
                    ->whereYear('affiliates.updated_at', '=', $year);
    }

    public function scopeAfiDistrict($query, $district, $year)
    {
       return $query = DB::table('affiliates')
                    ->select(DB::raw('COUNT(*) as district'))
                    ->leftJoin('units', 'affiliates.unit_id', '=', 'units.id')
                    ->leftJoin('affiliate_states', 'affiliates.affiliate_state_id', '=', 'affiliate_states.id')
                    ->leftJoin('affiliate_state_types', 'affiliate_states.affiliate_state_type_id', '=', 'affiliate_state_types.id')
                    ->where('units.district', '=', $district)
                    ->whereYear('affiliates.updated_at', '=', $year);
    }



    public function getFull_fech_ini_apor()
    {
        return Util::getDateAbrePeriod($this->fech_ini_apor);
    }
    public function getFull_fech_fin_apor()
    {
        return Util::getDateAbrePeriod($this->fech_fin_apor);
    }
    public function getYearsAndMonths_fech_ini_apor()
    {
        return Util::getYearsAndMonths($this->fech_ini_apor, $this->fech_fin_apor);
    }

    public function getFull_fech_ini_serv()
    {
        return Util::getDateAbrePeriod($this->fech_ini_serv);
    }
    public function getFull_fech_fin_serv()
    {
        return Util::getDateAbrePeriod($this->fech_fin_serv);
    }
    public function getYearsAndMonths_fech_fin_serv()
    {
        return Util::getYearsAndMonths($this->fech_ini_serv, $this->fech_fin_serv);
    }

    public function getData_fech_ini_apor()
    {
        return Util::getdateforEditPeriod($this->fech_ini_apor);
    }
    public function getData_fech_fin_apor()
    {
        return Util::getdateforEditPeriod($this->fech_fin_apor);
    }

    public function getData_fech_ini_serv()
    {
        return Util::getdateforEditPeriod($this->fech_ini_serv);
    }

    public function getData_fech_fin_serv()
    {
        return Util::getdateforEditPeriod($this->fech_fin_serv);
    }

    public function getData_fech_ini_anti()
    {
        return Util::getdateforEditPeriod($this->fech_ini_anti);
    }
    public function getData_fech_fin_anti()
    {
        return Util::getdateforEditPeriod($this->fech_fin_anti);
    }

    public function getData_fech_ini_reco()
    {
        return Util::getdateforEditPeriod($this->fech_ini_reco);
    }
    public function getData_fech_fin_reco()
    {
        return Util::getdateforEditPeriod($this->fech_fin_reco);
    }

    public function getFullName()
    {
    return $this->degree->name . ' ' . $this->last_name. ' ' . $this->mothers_last_name . ' ' . $this->surname_husband . ' ' . $this->first_name . ' ' . $this->second_name;
    }
    public function getFullNamePrintTotal()
    {
        $name = ($this->first_name)." ".($this->second_name)." ".($this->last_name)." ".($this->mothers_last_name)." ".($this->surname_husband);
        $re = '/\s+/';
        $subst = ' ';
        $result = preg_replace($re, $subst, $name);

        return $result;
    }
    public function getFullNameChange()
    {
        $name = ($this->last_name)." ".($this->mothers_last_name)." ".($this->surname_husband)." ".($this->first_name)." ".($this->second_name);
        $re = '/\s+/';
        $subst = ' ';
        $result = preg_replace($re, $subst, $name);
        return trim($result);
    }

    public function getFullNametoPrint()
    {
        return $this->last_name. ' ' . $this->mothers_last_name . ' ' . $this->surname_husband . ' ' . $this->first_name . ' ' . $this->second_name;
    }

    public function getFullDirecctoPrint()
    {
        return $this->street . ' ' . $this->number_address . ' ' . $this->zone. ' ' . $this->city_address_id;
    }

    public function getFullDateNactoPrint()
    {
        return Util::getfulldate($this->fech_nac);
    }

    public function getFull_fech_decetoPrint()
    {
        return Util::getfulldate($this->fech_dece);
    }

    public function getFullDateIngtoPrint()
    {
        return Util::getfulldate($this->date_entry);
    }
    public function getFull_fech_fin_aportoPrint()
    {
        return Util::getfulldate($this->fech_fin_apor);
    }
    public function getData_fech_bajatoPrint()
    {
        return Util::getfulldate($this->date_decommissioned);
    }

    public function getData_fech_ini_Reco_print()
    {
        if ($this->fech_ini_reco) {
            return $this->fech_ini_reco;
        }else{
            return $this->fech_ing;
        }
    }
    public function getData_fech_fin_Reco_print()
    {
        if ($this->fech_fin_reco) {
            return $this->fech_fin_reco;
        }else {
            $lastAporte = Aporte::afiliadoId($this->id)->orderBy('gest', 'desc')->first();
            return $lastAporte->gest;
        }
    }
    public function get_eco_com_reception_type()
    {
        $affiliate_id=$this->id;
        if (Util::getCurrentSemester() == 'Primer') {
            $last_semester_first = 'Segundo';
            $last_semester_second = 'Primer';
            $last_year_first = Carbon::now()->year - 1;
            $last_year_second = $last_year_first;
        }else{
            $last_semester_first = 'Primer';
            $last_semester_second = 'Segundo';
            $last_year_first = Carbon::now()->year ;
            $last_year_second = $last_year_first -1;
        }
        $eco_com_reception_type = 'Inclusion';
        $last_procedure_second = EconomicComplementProcedure::whereYear('year', '=', $last_year_second)->where('semester','like',$last_semester_second)->first();
        if (sizeof($last_procedure_second)>0) {
            if ($last_procedure_second->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $last_procedure_first = EconomicComplementProcedure::whereYear('year', '=', $last_year_first)->where('semester','like',$last_semester_first)->first();
        if (sizeof($last_procedure_first)>0) {
            if ($last_procedure_first->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        return $eco_com_reception_type;
    }

}

Affiliate::created(function($affiliate)
{
    AffiliateRecord::CreatedAffiliate($affiliate);
});

Affiliate::updating(function($affiliate)
{
    Activity::updateAffiliate($affiliate);
    AffiliateRecord::UpdatingAffiliate($affiliate);
});
