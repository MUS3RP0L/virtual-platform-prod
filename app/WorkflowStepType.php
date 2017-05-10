<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowStepType extends Model
{
	protected $table = 'wf_step_types';
	public function wf_step()
	{
		return $this->hasMany(Workflow::class,'workflow_id','id');
	}
}
