<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';
	protected $fillable = [

        'role_id',
		'user_id',
		'module_id'
    ];
	protected $guarded = ['id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
