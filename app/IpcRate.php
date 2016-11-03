<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

use Muserpol\Helper\Util;

class IpcRate extends Model
{
    protected $table = 'ipc_rates';

	protected $fillable = [
	
		'month_year',
		'index'
	];

	protected $guarded = ['id'];

	public function getMonthYearEdit()
    {	
        return Util::getdateforEditPeriod($this->month_year);
    }
}
