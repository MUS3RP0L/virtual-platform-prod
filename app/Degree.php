<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $table = 'degrees';

    protected $fillable = [
  		'hierarchy_id',
  		'code',
  		'name',
  		'shortened'
	];
	protected $guarded = ['id'];

	public function base_wages(){
        return $this->hasMany('Muserpol\BaseWage');
    }

    public function affiliates(){
        return $this->hasMany('Muserpol\Affiliate');
    }

    public function contributions(){
    	return $this->hasMany('Muserpol\Contribution');
    }

    public function hierarchy(){
        return $this->belongsTo('Muserpol\Hierarchy');
    }

    public function economic_complement_rents(){
      return $this->hasMany('Muserpol\EconomicComplementRent');
    }

    public function scopeHierarchyidIs($query, $id){
        return $query->where('hierarchy_id', $id);
    }

    public function getCodHierarchyName(){
        return $this->hierarchy->code ."-". $this->code ." ". $this->name;
    }
}
