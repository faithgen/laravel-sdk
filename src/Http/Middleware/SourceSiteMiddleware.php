<?php

namespace FaithGen\SDK\Http\Middleware;

use Closure;

class SourceSiteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('faithgen-sdk.source')) {
            return $next($request);
        } else {
            abort(403, 'You are not allowed to perform this action');
        }
    }
}
