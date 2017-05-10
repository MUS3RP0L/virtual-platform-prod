<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

	protected $fillable = [
		'name',
		'description'
	];

	protected $guarded = ['id'];

	public function workflows()
    {
        return $this->hasMany(Workflow::class);
    }
    public function roles()
    {
    	return $this->hasMany(Rol::class);
    }
    public function affiliate_obervations()
    {
        return $this->hasMany(AffiliateObservation::class);
    }

}
