<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementRequirement extends Model
{
    protected $table = 'eco_com_requirements';

    protected $fillable = [
        'eco_com_type_id',
        'name',
        'shortened'
    ];

    protected $guarded = ['id'];

    public function economic_complement_type(){
        return $this->belongsTo('Muserpol\EconomicComplementType', 'eco_com_modality_id');
    }

    public function economic_complement_submitted_documents(){
        return $this->hasMany('Muserpol\EconomicComplementSubmittedDocument');
    }

    public function scopeEconomicComplementTypeIs($query, $id){
        return $query->where('eco_com_type_id', $id);
    }

}
