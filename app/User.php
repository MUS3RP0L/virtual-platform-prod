<?php

namespace Muserpol;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = [

        'city_id',
        'first_name',
        'last_name',
        'phone',
        'username',
        'password',
        'status'

    ];

    protected $hidden = ['password'];
    public function economic_complements()
    {
        return $this->hasMany(EconomicComplement::class);
    }
    public function roles()
    {
    	return $this->belongsToMany(Role::class);
    }
    public function city()
    {
    	return $this->belongsTo(City::class);
    }
    public function wf_records()
    {
    	return $this->hasMany(WorkflowRecord::class);
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAllRolesToString(){

       $roles_list=[];
       foreach ($this->roles as $role) {
           $roles_list[]=$role->name;
       }
       return implode(",",$roles_list);

    }

    public function getModule(){
        return $this->roles()->first()->module;
    }
}
