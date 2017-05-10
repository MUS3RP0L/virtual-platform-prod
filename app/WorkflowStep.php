<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowStep extends Model
{
	protected $table = 'wf_steps';
	public function wf_step_type()
	{
		return $this->belongsTo(WorkflowStepType::class, 'wf_step_type_id','id');
	}
}
