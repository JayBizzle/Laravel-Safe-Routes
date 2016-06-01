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

use Illuminate\Routing\UrlGenerator as M;
use InvalidArgumentException;

class UrlGenerator extends M
{
    public function saferoute($name, $parameters = [], $absolute = true)
    {
        if (!is_null($route = $this->routes->getByName($name))) {
            $safe_parameters = $this->formatRouteParameters($parameters);

            return $this->toRoute($route, $safe_parameters, $absolute);
        }

        throw new InvalidArgumentException("Route [{$name}] not defined.");
    }

    public function formatRouteParameters($parameters)
    {
        foreach ($parameters as $key => $param) {
            $safe_parameters[$key] = \Safeurl::make($param);
        }

        return $safe_parameters;
    }
}
