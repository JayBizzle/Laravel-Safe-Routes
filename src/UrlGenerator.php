<?php namespace Jaybizzle\SafeRoutes;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\UrlGenerator as M;

class UrlGenerator extends M
{
	public function saferoute($name, $parameters = array(), $absolute = true)
	{
		if ( ! is_null($route = $this->routes->getByName($name)))
		{
			$safe_parameters = $this->formatRouteParameters($parameters);
			return $this->toRoute($route, $safe_parameters, $absolute);
		}

		throw new InvalidArgumentException("Route [{$name}] not defined.");
	}

	public function formatRouteParameters($parameters)
	{
		foreach($parameters as $key => $param) {
			$safe_parameters[$key] = \Safeurl::make($param);
		}

		return $safe_parameters;
	}
}
