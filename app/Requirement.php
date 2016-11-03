<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $table = 'requirements';

	protected $fillable = [

        'retirement_fund_modality_id',
		'name',
        'shortened'
	];

	protected $guarded = ['id'];

	public function retirement_fund_modalities()
    {
        return $this->belongsTo('Muserpol\RetirementFundModality');
    }

    public function documents()
    {
        return $this->hasMany('Muserpol\Document');
    }

    public function scopeModalityIs($query, $id)
    {
        return $query->where('retirement_fund_modality_id', $id);
    }
}
