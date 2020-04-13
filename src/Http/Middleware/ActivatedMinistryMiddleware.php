<?php

namespace FaithGen\SDK\Http\Middleware;

use Closure;

class ActivatedMinistryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth(config('faithgen-sdk.guard'))->user()->activation->active) {
            return $next($request);
        } else {
            abort(403, 'You need to activate you account first to access this part');
        }
    }
}
