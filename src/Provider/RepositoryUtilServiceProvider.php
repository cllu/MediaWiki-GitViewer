<?php

namespace GitList\Provider;

use GitList\Util\Repository;
use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;

class RepositoryUtilServiceProvider implements ServiceProviderInterface
{
    /**
     * Register the Util\Repository class on the Application ServiceProvider
     *
     * @param Application $app Silex Application
     */
    public function register(Container $app)
    {
        $app['util.repository'] = function () use ($app) {
            return new Repository($app);
        };
    }

    public function boot(Application $app)
    {
    }
}
