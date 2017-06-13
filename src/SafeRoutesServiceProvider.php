<?php

/*
 * This file is part of the Laravel Safe Routes package.
 *
 * (c) Mark Beech <m@rkbee.ch>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Jaybizzle\SafeRoutes;

use Illuminate\Routing\RoutingServiceProvider as RSP;

class SafeRoutesServiceProvider extends RSP
{
    public function register()
    {
        /*
         * Register the service provider for the dependency.
         */
        $this->app->register('Jaybizzle\Safeurl\SafeurlServiceProvider');

        /*
         * Create aliases for the dependency.
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Safeurl', 'Jaybizzle\Safeurl\Facades\Safeurl');

        $this->registerUrlGenerator();
    }

    /**
     * Register the URL generator service.
     *
     * @return void
     */
    protected function registerUrlGenerator()
    {
        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();

            // The URL generator needs the route collection that exists on the router.
            // Keep in mind this is an object, so we're passing by references here
            // and all the registered routes will be available to the generator.
            $app->instance('routes', $routes);

            $url = new UrlGenerator(
                $routes, $app->rebinding(
                    'request', $this->requestRebinder()
                )
            );

            $url->setSessionResolver(function () {
                return $this->app['session'];
            });

            // If the route collection is "rebound", for example, when the routes stay
            // cached for the application, we will need to rebind the routes on the
            // URL generator instance so it has the latest version of the routes.
            $app->rebinding('routes', function ($app, $routes) {
                $app['url']->setRoutes($routes);
            });

            return $url;
        });
    }
}
