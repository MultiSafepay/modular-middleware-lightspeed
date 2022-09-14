<?php
namespace Modularlightspeed\Modularlightspeed\Middleware;

use Closure;
use Illuminate\Http\Request;

class lightspeedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // validate signature, set the credentials
        if (!$request->header('x-shop-id') && $request->header('x-shop-id') != $request->route('lightspeed')->shop_id) {
            return response('Not Authorized', 401);
        }

        return $next($request);
    }
}
