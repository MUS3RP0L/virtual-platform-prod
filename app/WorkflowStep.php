<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowStep extends Model
{
	protected $table = 'wf_steps';
	protected $fillable = [
		'workflow_id',
		'role_id',
		'wf_step_type_id',
		'name'
	];

	protected $guarded = ['id'];
	public function wf_step_type()
	{
		return $this->belongsTo(WorkflowStepType::class);
	}
	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
