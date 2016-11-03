<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Muserpol\Helper\Util;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $dates = ['deleted_at'];

	protected $fillable = [

        'user_id',
        'affiliate_id',
        'voucher_type_id',
        'contribution_type_id',
        'code',
        'concept',
        'total',
        'payment_date'

	];

	protected $guarded = ['id'];

    public function affiliate() {

        return $this->belongsTo('Muserpol\Affiliate');
    }

    public function voucher_type() {

        return $this->belongsTo('Muserpol\VoucherType');
    }

    public function scopeIdIs($query, $id) {
        return $query->where('id', $id);
    }

    public function getCreationDate() {

        return Util::getDateShort($this->created_at);
    }

}
