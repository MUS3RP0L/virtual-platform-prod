<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

use Muserpol\Helper\Util;

class ComplementaryFactor extends Model
{
    protected $table = 'complementary_factors';

	protected $fillable = [
        'user_id'
		'hierarchy_id',
		'year',
		'semester',
		'old_age',
		'widowhood'

	];

	protected $guarded = ['id'];

	public function economic_complements()
    {
        return $this->hasMany('Muserpol\EconomicComplement');
    }

    public function hierarchy()
    {
        return $this->belongsTo('Muserpol\Hierarchy');
    }

    public function scopeHierarchyIs($query, $id)
    {
        return $query->where('hierarchy_id', $id);
    }

}
