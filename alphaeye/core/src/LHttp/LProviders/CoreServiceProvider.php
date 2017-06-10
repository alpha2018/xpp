<?php namespace AlphaEyeCore\LHttp\LProviders;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // 注册路由
//        if (! $this->app->routesAreCached()) {
//            require __DIR__ . '/../Http/routes.php';
//            require __DIR__ . '/../../../routes/auth.php';
//        }

        // 注册视图
        //$this->loadViewsFrom(__DIR__ . '/../../../resources/views/', 'auth');
        // 注册视图
//        $this->loadViewsFrom(__DIR__.'/../../../resources/views', 'backend');

        // 注册帮助方法
        require_once __DIR__ .'/../../Functions/helpers.php';
    }
}