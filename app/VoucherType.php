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
    public $timestamps=false;
    public function vouchers()
    {
        return $this->hasMany('Muserpol\Voucher');
    }
}
