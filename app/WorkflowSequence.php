<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowSequence extends Model
{
    protected $table = 'wf_sequences';
    public function workflow()
    {
    	return $this->belongsTo(Workflow::class,'workflow_id','id');
    }
}
