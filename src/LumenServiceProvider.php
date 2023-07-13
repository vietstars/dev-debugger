<?php

namespace Vietstars\DevDebugger;

use Laravel\Lumen\Application;

class LumenServiceProvider extends ServiceProvider
{
    /** @var  Application */
    protected $app;

    /**
     * Get the active router.
     *
     * @return Application
     */
    protected function getRouter()
    {
        return $this->app->router;
    }

    /**
     * Get the config path
     *
     * @return string
     */
    protected function getConfigPath()
    {
        return base_path('config/DevDebugger.php');
    }

    /**
     * Register the Debugbar Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $this->app->middleware([$middleware]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['debugbar', 'command.debugbar.clear'];
    }
}
