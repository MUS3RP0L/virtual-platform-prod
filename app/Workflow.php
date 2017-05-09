<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    public function module()
    {
    	return $this->belongsTo(Module::class);
    }
    public function wf_sequences()
    {
    	return $this->hasMany(WorkflowSequence::class,'workflow_id','id');
    }
}
