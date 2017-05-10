<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'module_id',
        'name'
    ];

    protected $guarded = ['id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function scopeModuleidIs($query, $id)
    {
        return $query->where('module_id', $id);
    }

    public function role_users()
    {
    	return $this->hasMany(RoleUser::class);
    }
    public function wf_steps()
    {
    	return $this->hasMany(WorkflowStep::class);
    }


}
