<?php

namespace Muserpol\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Muserpol\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);
        $router->model('user', 'Muserpol\User');
        $router->model('contribution_rate', 'Muserpol\ContributionRate');
        $router->model('ipc_rate', 'Muserpol\IpcRate');
        $router->model('base_wage', 'Muserpol\BaseWage');
        $router->model('affiliate', 'Muserpol\Affiliate');
        $router->model('direct_contribution', 'Muserpol\DirectContribution');
        $router->model('voucher', 'Muserpol\Voucher');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
