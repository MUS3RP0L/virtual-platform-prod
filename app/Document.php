<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Muserpol\Helper\Util;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [

    	'requirement_id',
    	'retirement_fund_id',
    	'reception_date',
    	'status',
    	'comment'

    ];

    protected $guarded = ['id'];

    public function retirement_fund(){

        return $this->belongsTo('Muserpol\RetirementFund');
    }

    public function requirement(){

        return $this->belongsTo('Muserpol\Requirement');
    }

    public function scopeRetirementFundIs($query, $id)
    {
        return $query->where('retirement_fund_id', $id);
    }

    public function getData_fech_requi()
    {
        return Util::getDateAbrePeriod($this->reception_date);
    }
    public function getDataEdit()
    {
        return Util::getdateforEdit($this->fech_pres);
    }
}

Document::created(function($document)
{
    Activity::createdDocument($document);

});

Document::updating(function($document)
{
    Activity::updateDocument($document);

});
