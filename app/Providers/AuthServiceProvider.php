<?php

namespace Muserpol\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Muserpol\User;
use Muserpol\Policies\EconomicComplementPolicy;
use Muserpol\EconomicComplement;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {

        parent::registerPolicies($gate);
            
        $gate->before(function ($user, $ability) {
            foreach ($user->roles as $role) {
                        if($role->id==1){
                            return true;
                        }
                }
        });

        $gate->define('manage', function ($user) {
            foreach ($user->roles as $role) {
                if ($role->id==1) {
                    return true;
                }
            }
            return false;
        });

        $gate->define('economic_complement',function($user){
                foreach ($user->roles as $role) {
                         if(($role->id==8) || ($role->id==10) || ($role->id==9)){
                            return true;
                         }
                    }
                return false;
        });

    // verify if icurrent user have role reception of economic complement 
        $gate->define('eco_com_reception',function($user){
                foreach ($user->roles as $role) {
                        if($role->id==8 || $role->id==10){
                            return true;
                        }
                }
                return false;
        });

    //verify if current user have role review of economic complement
        $gate->define('eco_com_review',function($user){
            foreach ($user->roles as $role) {
                    if($role->id==9 || $role->id==10){
                        return true;
                    }
            }
            return false;
        });
    }
}
