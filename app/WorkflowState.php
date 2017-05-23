<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowState extends Model
{
    protected $table = 'wf_states';
	protected $fillable = [
		'workflow_id' , 'role_id' , 'name'
	];
	public $timestamps=false;
	protected $guarded = ['id'];
	public function economic_complements()
	{
		return $this->hasMany(EconomicComplement::class,'wf_current_state_id','id');
	}
}
