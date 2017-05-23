<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $table = 'workflows';
    protected $fillable = [
        'module_id',
        'name',
        'description'
    ];

    protected $guarded = ['id'];

    public $timestamps = false;

    public function module()
    {
    	return $this->belongsTo(Module::class);
    }
    public function wf_sequences()
    {
    	return $this->hasMany(WorkflowSequence::class);
    }
    public function economic_complements()
    {
        return $this->hasMany('Muserpol\EconomicComplement');
    }
}
