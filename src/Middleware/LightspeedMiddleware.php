<?php
namespace ModularLightspeed\ModularLightspeed\Middleware;

use Closure;
use Illuminate\Http\Request;

class LightspeedMiddleware
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
        if (!$request->header('x-shop-id') && $request->header('x-shop-id') != $request->route('Lightspeed')->shop_id) {
            return response('Not Authorized', 401);
        }

        return $next($request);
    }
}
