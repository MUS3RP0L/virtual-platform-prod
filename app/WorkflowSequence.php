<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class WorkflowSequence extends Model
{
    protected $table = 'wf_sequences';
    protected $fillable = [
        'workflow_id',
        'wf_step_current_id',
        'wf_step_next_id'
    ];

    protected $guarded = ['id'];
    public function workflow()
    {
    	return $this->belongsTo(Workflow::class);
    }
}
