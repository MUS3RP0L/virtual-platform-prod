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
    public $timestamps=false;
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

    public function economic_complement_legal_guardian()
    {
        return $this->hasMany(EconomicComplementLegalGuardian::class);
    }

    public function economic_complement_applicant()
    {
        return $this->hasMany(EconomicComplementApplicant::class);
    }
	public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }
    public function getName()
    {
        return $this->name;
    }
}
