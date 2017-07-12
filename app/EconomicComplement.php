<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Session;
use Muserpol\Helper\Util;

class EconomicComplement extends Model
{
    use SoftDeletes;

    protected $table = 'economic_complements';

    protected $dates = ['deleted_at'];

	protected $fillable = [
        'user_id',
        'affiliate_id',
        'eco_com_modality_id',
    	'eco_com_procedure_id',
    	'wf_current_state_id',
        'city_id',
        'category_id',
        'base_wage_id',
        'complementary_factor_id',
        'has_legal_guardian',
        'code',
        'reception_date',
        'review_date',
        'year',
        'semester',
        'sub_total_rent',
        'reimbursement_basic_pension',
        'dignity_pension',
        'dignity_pension_reimbursement',
        'dignity_pension_bonus',
        'bonus_reimbursement',
        'reimbursement_aditional_amount',
        'reimbursement_increase_year',
        'total_rent',
        'total_rent_calc',
        'salary_reference',
        'seniority',
        'salary_quotable',
        'difference',
        'total_amount_semester',
        'complementary_factor',
        'reimbursement',
        'christmas_bonus',
        'quotable',
        'total',
        'payment_date',
        'payment_number',
        'comment',
        'eco_com_procedure_id'
	];

	protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('Muserpol\User');
    }
	public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }

	public function economic_complement_modality()
    {
        return $this->belongsTo('Muserpol\EconomicComplementModality', 'eco_com_modality_id');
    }

    public function city()
    {
        return $this->belongsTo('Muserpol\City');
    }

    public function category()
    {
        return $this->belongsTo('Muserpol\Category');
    }

    public function base_wage()
    {
        return $this->belongsTo('Muserpol\BaseWage');
    }

    public function complementary_factor()
    {
        return $this->belongsTo('Muserpol\ComplementaryFactor');
    }

    public function economic_complement_submitted_documents()
    {
        return $this->hasMany('Muserpol\EconomicComplementSubmittedDocument');
    }

    public function economic_complement_applicant()
    {
        return $this->hasOne('Muserpol\EconomicComplementApplicant');
    }
    public function economic_complement_legal_guardian()
    {
        return $this->hasOne('Muserpol\EconomicComplementLegalGuardian');
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeAffiliateIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
    }

    public function getCreationDate()
    {
        return Util::getDateShort($this->reception_date);
    }

    public function getCode()
    {
        return "Proceso N° " . $this->code;
    }
    public function economic_complement_procedure()
    {
        return $this->belongsTo(EconomicComplementProcedure::class);
    }
    public function economic_complement_state()
    {
        return $this->belongsTo(EconomicComplementState::class);
    }
    public function workflow()
    {
        return $this->belongsTo('Muserpol\Workflow');
    }
    public function wf_state()
    {
        return $this->belongsTo('Muserpol\WorkflowState','wf_current_state_id');
    }

    public function getYear()
    {
        if($this->year){
            return Util::getYear($this->year);
        }
    }
    public function getReceptionDate()
    {
        if($this->reception_date){
            
            return Util::getDateShort($this->year);
        }
    }
    /**
     * @param  EconomicComplement
     * @param  [type]
     * @param  [type]
     * @param  [type]
     * @param  [type]
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public static function calculate(EconomicComplement $economic_complement, $sub_total_rent, $reimbursement, $dignity_pension, $aps_total_fsa, $aps_total_cc, $aps_total_fs)
    {
        $economic_complement_rent_temp = EconomicComplementRent::whereYear('year','=',Carbon::parse($economic_complement->year)->year)
                                            ->where('semester','=',$economic_complement->semester)
                                            ->get();
        $base_wage_temp = BaseWage::whereYear('month_year','=',Carbon::parse($economic_complement->year)->year)->get();
        if (sizeof($base_wage_temp) > 0 && sizeof($economic_complement_rent_temp) > 0) {
            $total_rent = floatval(str_replace(',','',$sub_total_rent))-floatval(str_replace(',','',$reimbursement))-floatval(str_replace(',','',$dignity_pension));
            //APS
            if($economic_complement->affiliate->pension_entity->type=='APS'){
                $comp=0;
                if (floatval(str_replace(',','',$aps_total_fsa)) > 0) {
                    $comp++;
                }
                if (floatval(str_replace(',','',$aps_total_cc)) > 0) {
                    $comp++;
                }
                if (floatval(str_replace(',','',$aps_total_fs)) > 0) {
                    $comp++;
                }
                $economic_complement->aps_total_fsa=floatval(str_replace(',','',$aps_total_fsa));
                $economic_complement->aps_total_cc=floatval(str_replace(',','',$aps_total_cc));
                $economic_complement->aps_total_fs=floatval(str_replace(',','',$aps_total_fs));
                //vejez
                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 1){
                    if ($comp == 1 && $total_rent >= 2000){
                        $economic_complement->eco_com_modality_id = 4;
                    }elseif ($comp == 1 && $total_rent < 2000){
                        $economic_complement->eco_com_modality_id = 6;
                    }elseif ($comp > 1 && $total_rent < 2000){
                        $economic_complement->eco_com_modality_id = 8;
                    }else{
                        $economic_complement->eco_com_modality_id = 1;
                    }
                }
                //Viudedad
                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 2){
                    if($comp == 1 && $total_rent >= 2000){
                        $economic_complement->eco_com_modality_id = 5;
                    }elseif ($comp == 1 && $total_rent < 2000){
                        $economic_complement->eco_com_modality_id = 7;
                    }elseif ($comp > 1 && $total_rent < 2000 ){
                        $economic_complement->eco_com_modality_id = 9;
                    }else{
                        $economic_complement->eco_com_modality_id = 2;
                    }
                }
                //orfandad
                if ($economic_complement->economic_complement_modality->economic_complement_type->id == 3){
                    if ($comp == 1 && $total_rent >= 2000){
                        $economic_complement->eco_com_modality_id = 10;
                    }elseif ($comp == 1 && $total_rent < 2000){
                        $economic_complement->eco_com_modality_id = 11;
                    }elseif ($comp > 1 && $total_rent < 2000){
                        $economic_complement->eco_com_modality_id = 12;
                    }else{
                        $economic_complement->eco_com_modality_id = 3;
                    }
                }
            }else{
            //Senasir
                if($economic_complement->economic_complement_modality->economic_complement_type->id == 1 && $total_rent < 2000){
                    //vejez
                    $economic_complement->eco_com_modality_id = 8;
                }elseif ($economic_complement->economic_complement_modality->economic_complement_type->id == 2 && $total_rent < 2000){
                    //Viudedad  
                    $economic_complement->eco_com_modality_id = 9;
                }elseif($economic_complement->economic_complement_modality->economic_complement_type->id == 3 && $total_rent < 2000){ //Orfandad 
                    $economic_complement->eco_com_modality_id = 12;
                }else {
                    $economic_complement->eco_com_modality_id = $economic_complement->economic_complement_modality->economic_complement_type->id;
                }
            }
            $economic_complement->total_rent = $total_rent;
            $economic_complement->save();
            $economic_complement->total_rent_calc = $total_rent;
            //para el promedio
            if ($economic_complement->eco_com_modality_id > 3) {
                $economic_complement_rent = EconomicComplementRent::where('degree_id','=',$economic_complement->affiliate->degree->id)
                                        ->where('eco_com_type_id','=',$economic_complement->economic_complement_modality->economic_complement_type->id)
                                        ->whereYear('year','=',Carbon::parse($economic_complement->year)->year)
                                        ->where('semester','=',$economic_complement->semester)
                                        ->first();
                $total_rent=$economic_complement_rent->average;
                $economic_complement->total_rent_calc = $economic_complement_rent->average;
            }
            $base_wage = BaseWage::degreeIs($economic_complement->affiliate->degree_id)->whereYear('month_year','=',Carbon::parse($economic_complement->year)->year)->first();

            //para el caso de las viudas 80%
            if ($economic_complement->economic_complement_modality->economic_complement_type->id == 2) {
                $base_wage_amount = $base_wage->amount*(80/100);
                $salary_reference = $base_wage_amount;
                $seniority = $economic_complement->category->percentage * $base_wage_amount;
            }else{
                $salary_reference = $base_wage->amount;
                $seniority = $economic_complement->category->percentage * $base_wage->amount;
            }

            $economic_complement->seniority=$seniority;
            $salary_quotable = $salary_reference + $seniority;
            $economic_complement->salary_quotable = $salary_quotable;
            $difference = $salary_quotable - $total_rent;
            $economic_complement->difference = $difference;
            $months_of_payment = 6;
            $total_amount_semester = $difference * $months_of_payment;
            $economic_complement->total_amount_semester=$total_amount_semester;
            $economic_complement->sub_total_rent=floatval(str_replace(',','',$sub_total_rent));
            $economic_complement->reimbursement=floatval(str_replace(',','',$reimbursement));
            $economic_complement->dignity_pension=floatval(str_replace(',','',$dignity_pension));
            $complementary_factor = ComplementaryFactor::hierarchyIs($base_wage->degree->hierarchy->id)
                                                        ->whereYear('year', '=', Carbon::parse($economic_complement->year)->year)
                                                        ->where('semester', '=', $economic_complement->semester)->first();
            $economic_complement->complementary_factor_id = $complementary_factor->id;
            if ($economic_complement->economic_complement_modality->eco_com_type_id == 2 ) {
                //viudedad
                $complementary_factor=$complementary_factor->widowhood;
            }else{
                //vejez
                $complementary_factor=$complementary_factor->old_age;
            }
            $economic_complement->complementary_factor = $complementary_factor;
            $total = $total_amount_semester * floatval($complementary_factor)/100;
            $economic_complement->total = $total;
            $economic_complement->base_wage_id = $base_wage->id;
            $economic_complement->salary_reference = $salary_reference;
            //$economic_complement->state = 'Edited';
            $economic_complement->save();
        }else{
            return redirect('economic_complement/'.$economic_complement->id)
            ->withErrors('Verifique si existen sueldos, promedios y factor de complementacion.')
            ->withInput();
        }
    }
}

EconomicComplement::created(function($ecomplement)
{
    Activity::createdEconomicComplement($ecomplement);
});

EconomicComplement::updated(function($ecomplement)
{
    Activity::updateEconomicComplement($ecomplement);

});
