<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class AffiliateAddress extends Model
{
    protected $table = 'affiliate_address';

    protected $fillable = [

        'affiliate_id',
        'city_address_id',
        'zone',
        'street',
        'number_address'
    ];

    protected $guarded = ['id'];

    public function affiliate()
    {
        return $this->belongsTo('Muserpol\Affiliate');
    }

    public function scopeAffiliateidIs($query, $id)
    {
        return $query->where('affiliate_id', $id);
    }

}
