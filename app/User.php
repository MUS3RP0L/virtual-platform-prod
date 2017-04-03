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

        'rol_id',
        'first_name',
        'last_name',
        'phone',
        'username',
        'password',
        'status'

    ];

    protected $hidden = ['password'];

    public function role()
    {
        return $this->belongsTo('Muserpol\Role');
    }

    public function scopeIdIs($query, $id)
    {
        return $query->where('id', $id);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
