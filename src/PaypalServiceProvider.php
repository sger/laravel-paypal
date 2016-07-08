<?php

namespace Sger\Paypal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
use PayPal\Rest\ApiContext;

class PaypalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

        /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/../config/paypal.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('paypal.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('paypal');
        }

        $this->mergeConfigFrom($source, 'paypal');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this->app->singleton('paypal.factory', function () {
            return new PaypalFactory();
        });

        $this->app->alias('paypal.factory', PaypalFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton('paypal', function (Container $app) {
            $config = $app['config'];
            $factory = $app['paypal.factory'];
            
            return new PaypalManager($config, $factory);
        });

        $this->app->alias('paypal', PaypalManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('paypal.connection', function (Container $app) {
            $manager = $app['paypal'];

            return $manager->connection();
        });

        $this->app->alias('paypal.connection', ApiContext::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'paypal',
            'paypal.factory',
            'paypal.connection',
        ];
    }
}
