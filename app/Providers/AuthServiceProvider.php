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
                if($role->id == 1){
                    return true;
                }
            }
            return false;
        });

        $gate->define('manage', function ($user) {
            foreach ($user->roles as $role) {
                if ($role->id == 1) {
                    return true;
                }
            }
            return false;
        });

        $gate->define('economic_complement',function($user){
            if($user->roles()->first()->module->id == 2){
                return true;
            }
            return false;
        });

        $gate->define('eco_com_reception',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 2){
                    return true;
                }
            }
            return false;
        });

        $gate->define('eco_com_review',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 3){
                    return true;
                }
            }
            return false;
        });

        $gate->define('eco_com_qualification',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 4){
                    return true;
                }
            }
            return false;
        });

        $gate->define('eco_com_approval',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 5){
                    return true;
                }
            }
            return false;
        });

        $gate->define('eco_com_lawyer',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 6){
                    return true;
                }
            }
            return false;
        });

        $gate->define('accounting',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 7){
                    return true;
                }
            }
            return false;
        });
  
        $gate->define('budget',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 8){
                    return true;
                }
            }
            return false;
        });

        $gate->define('treasury',function($user){
            foreach ($user->roles as $role) {
                if($role->id == 9){
                    return true;
                }
            }
            return false;
        });

        //roles for Retirement fund
        // $gate->define('retirement_fund',function($user){
        //         foreach ($user->roles as $role) {
        //                  if(($role->id >= 2 && $role->id <= 7)){
        //                     return true;
        //                  }
        //             }
        //         return false;
        // });

        // verify if icurrent user have role reception of Retirement fund
        // $gate->define('reti_fund_reception',function($user){
        //         foreach ($user->roles as $role) {
        //                 if($role->id==2 || $role->id==7){
        //                     return true;
        //                 }
        //         }
        //         return false;
        // });

        //verify if current user have role review of Retirement fund
        // $gate->define('reti_fund_review',function($user){
        //     foreach ($user->roles as $role) {
        //             if($role->id==3 || $role->id==7){
        //                 return true;
        //             }
        //     }
        //     return false;
        // });

        //verify if current user have role archive of Retirement fund
        // $gate->define('reti_fund_archive',function($user){
        //     foreach ($user->roles as $role) {
        //             if($role->id==4 || $role->id==7){
        //                 return true;
        //             }
        //     }
        //     return false;
        // });

        //verify if current user have role qualification of Retirement fund
        // $gate->define('reti_fund_qualification',function($user){
        //     foreach ($user->roles as $role) {
        //             if($role->id==5 || $role->id==7){
        //                 return true;
        //             }
        //     }
        //     return false;
        // });

        //verify if current user have role Dictum legal of Retirement fund
        // $gate->define('reti_fund_dictum_legal',function($user){
        //     foreach ($user->roles as $role) {
        //             if($role->id==6 || $role->id==7){
        //                 return true;
        //             }
        //     }
        //     return false;
        // });
    }
}
