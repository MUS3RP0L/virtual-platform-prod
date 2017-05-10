<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

	protected $fillable = [

		'name',
		'shortened'

	];

	protected $guarded = ['id'];
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function affiliate_address()
    {
        return $this->hasMany(AffiliateAddress::class);
    }
    public function economic_complement()
    {
        return $this->hasMany('Muserpol\EconomicComplement');
    }

    public function spouses()
    {
        return $this->hasMany('Muserpol\Spouse');
    }

	public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }
}
