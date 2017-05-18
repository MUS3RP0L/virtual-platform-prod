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
}
