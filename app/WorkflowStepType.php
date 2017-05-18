<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowStepType extends Model
{
	protected $table = 'wf_step_types';
    protected $fillable = [
        'name',
        'description'
    ];

    protected $guarded = ['id'];

    public $timestamps = false;

	public function wf_steps()
	{
		return $this->hasMany(WorkflowStep::class);
	}
}
