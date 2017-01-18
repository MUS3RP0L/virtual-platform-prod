<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementSubmittedDocument extends Model
{
    protected $table = 'eco_com_submitted_documents';

    protected $fillable = [

        'economic_complement_id',
        'eco_com_requirement_id',
        'reception_date',
        'status',
        'comment'

    ];

    protected $guarded = ['id'];

    public function economic_complement_requirement(){
        return $this->belongsTo('Muserpol\EconomicComplementRequirement');
    }

    public function economic_complement(){
        return $this->belongsTo('Muserpol\EconomicComplement');
    }

    public function scopeEconomicComplementIs($query, $id){
        return $query->where('economic_complement_id', $id);
    }

}
