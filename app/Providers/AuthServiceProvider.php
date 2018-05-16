<?php

namespace Muserpol\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Muserpol\User;
use Muserpol\Policies\EconomicComplementPolicy;
use Muserpol\EconomicComplement;
use Carbon\Carbon;
use Muserpol\WorkflowRecord;
use Muserpol\Helper\Util;

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
        
        EconomicComplement::updated(function($economic_complement)
        {
            WorkflowRecord::updatedEconomicComplement($economic_complement);
        });
        EconomicComplement::creating(function($economic_complement)
        {
            WorkflowRecord::creatingEconomicComplement($economic_complement);
        });

        parent::registerPolicies($gate);
            
        $gate->before(function ($user, $ability) {
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 1){
                    return true;
                }
            // }
        });

        $gate->define('manage', function ($user) {
            // foreach ($user->roles as $role) {
                if (Util::getRol()->id == 1) {
                    return true;
                }
            // }
            return false;
        });

        $gate->define('economic_complement',function($user){
            if(Util::getRol()->module_id == 2){
                return true;
            }
            return false;
        });

        $gate->define('economic_complement-treasury',function($user){

            if(Util::getRol()->module_id == 2 || Util::getRol()->module_id == 9|| Util::getRol()->module_id == 8)
            {
                return true;
            }
            return false;
        });
        $gate->define('eco_com_reception',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 2 || Util::getRol()->id == 22 || Util::getRol()->id == 23 || Util::getRol()->id == 24 || Util::getRol()->id == 25 || Util::getRol()->id == 26 || Util::getRol()->id == 27 ){
                    return true;
                }
            // }
            return false;
        });
        $gate->define('eco_com-ret_fun_reception',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 10 ||  Util::getRol()->id == 2 || Util::getRol()->id == 22 || Util::getRol()->id == 23 || Util::getRol()->id == 24 || Util::getRol()->id == 25 || Util::getRol()->id == 26 || Util::getRol()->id == 27 ){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('eco_com_review',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 4){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('eco_com_review_and_reception',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 4 || Util::getRol()->id == 2 || Util::getRol()->id == 22 || Util::getRol()->id == 23 || Util::getRol()->id == 24 || Util::getRol()->id == 25 || Util::getRol()->id == 26 || Util::getRol()->id == 27){
                    return true;
                }
            // }
            return false;
        });
        $gate->define('eco_com_review_reception_calification',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 3 || Util::getRol()->id == 2 || Util::getRol()->id == 4 || Util::getRol()->id == 22 || Util::getRol()->id == 23 || Util::getRol()->id == 24 || Util::getRol()->id == 25 || Util::getRol()->id == 26 || Util::getRol()->id == 27){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('eco_com_review_reception_calification_contabilidad',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 3 || Util::getRol()->id == 6 || Util::getRol()->id == 2 || Util::getRol()->id == 4 || Util::getRol()->id == 7 ||  Util::getRol()->id ==16 || Util::getRol()->id == 22 || Util::getRol()->id == 23 || Util::getRol()->id == 24 || Util::getRol()->id == 25 || Util::getRol()->id == 26 || Util::getRol()->id == 27 ){
                    return true;
                }
            // }
            return false;
        });
        $gate->define('eco_com_qualification',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 4){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('eco_com_approval',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 5){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('eco_com_lawyer',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 6){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('accounting',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 7){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('loan',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 8){
                    return true;
                }
            // }
            return false;
        });
  
        $gate->define('budget',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 8){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('treasury',function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 9){
                    return true;
                }
            // }
            return false;
        });

        $gate->define('retirement_fund',function($user){
            if(Util::getRol()->module_id == 3){
                return true;
            }
            return false;
        });

        $gate->define('observate', function($user){
            // foreach ($user->roles as $role) {
                if(Util::getRol()->id == 2 || Util::getRol()->id == 3 || Util::getRol()->id == 4 || Util::getRol()->id == 7 || Util::getRol()->id == 16 || Util::getRol()->id == 17 || Util::getRol()->id == 22 || Util::getRol()->id == 23 || Util::getRol()->id == 24 || Util::getRol()->id == 25 || Util::getRol()->id == 26 || Util::getRol()->id == 27){
                    return true;
                }
            // }
            return false;
        });


         $gate->define('showEdit', function ($user, $economic_complement) {

            $showEdit=false;
            
            if(strval(Carbon::parse($economic_complement->year)->year) == Util::getYear(Carbon::now()) &&
                Util::getCurrentSemester() == $economic_complement->semester
                ){
                 $showEdit = true;
            }

            return $showEdit;
        });

      

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
