<?php

namespace GitList\Provider;

use GitList\Util\Routing;
use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class RoutingUtilServiceProvider implements ServiceProviderInterface {
    /**
     * Register the Util\Repository class on the Application ServiceProvider
     *
     * @param Application $app Silex Application
     */
    public function register(Container $app) {
        $app['util.routing'] = function () use ($app) {
            return new Routing($app);
        };
    }

    public function boot(Application $app) {
    }
}
