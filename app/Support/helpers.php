<?php

use Illuminate\Support\Facades\URL;

if (! function_exists('secure_route')) {
    /**
     * Generate a route URL that uses HTTPS when the current environment or app URL requires it.
     */
    function secure_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        $route = route($name, $parameters, false);
        $appUrl = (string) config('app.url');
        $appScheme = parse_url($appUrl, PHP_URL_SCHEME);
        $requestIsSecure = request()?->isSecure() ?? false;
        $shouldUseHttps = $requestIsSecure || $appScheme === 'https' || app()->isProduction();

        if (! $shouldUseHttps) {
            return route($name, $parameters, $absolute);
        }

        return secure_url($route);
    }
}
