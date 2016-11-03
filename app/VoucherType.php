<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model
{
    protected $table = 'voucher_types';

    protected $fillable = [

        'name'

    ];

    protected $guarded = ['id'];

    public function vouchers()
    {
        return $this->hasMany('Muserpol\Voucher');
    }
}
