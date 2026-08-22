<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 301 trailing-slash URLs to their non-trailing-slash equivalent so the
 * site serves each page at exactly one canonical URL.
 *
 * Production is nginx, so the trailing-slash strip rule in public/.htaccess
 * never runs. Without this middleware, /foo and /foo/ both return 200 with
 * the same content, deduplicated only by the canonical tag.
 *
 * Only GET/HEAD are redirected — anything else (form POSTs to trailing-slash
 * URLs) would drop the request body if 301'd.
 */
class TrimTrailingSlash
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->getMethod(), ['GET', 'HEAD'], true)) {
            return $next($request);
        }

        $path = $request->getPathInfo();

        if ($path === '/' || ! str_ends_with($path, '/')) {
            return $next($request);
        }

        $target = rtrim($path, '/');

        if ($query = $request->getQueryString()) {
            $target .= '?'.$query;
        }

        return redirect($target, 301);
    }
}
