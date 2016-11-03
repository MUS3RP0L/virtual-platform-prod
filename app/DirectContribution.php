<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\Contribution;

class DirectContribution extends Model
{
    protected $table = 'direct_contributions';

    protected $dates = ['deleted_at'];

	protected $fillable = [

        'user_id',
        'affiliate_id',
        'type',
        'code',
        'quotable',
        'retirement_fund',
        'mortuary_quota',
        'mortuary_aid',
        'subtotal',
        'ipc',
        'total'

	];

	protected $guarded = ['id'];

    public function affiliate(){

        return $this->belongsTo('Muserpol\Affiliate');
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }

    public function period()
    {
       $second = Contribution::select('month_year')->where('contributions.direct_contribution_id', '=', $this->id)->orderBy('id', 'desc')->first();
       $first = Contribution::select('month_year')->where('contributions.direct_contribution_id', '=', $this->id)->orderBy('id', 'asc')->first();

       return "De " . Util::getDateAbrePeriod($first->month_year) ." a " . Util::getDateAbrePeriod($second->month_year);
    }
}
