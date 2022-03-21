<?php

namespace App\Http\Middleware;

use Closure;

class CORS
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
        $domains =['http://localhost/laravel/SFE/public/api'];

        if(isset($request->server()['HTTP_ORIGIN'])){
            $origin = $request->server()['HTTP_ORIGIN'];
            if(in_array($origin, $domains)){
                header('Access-Control-Allow-Origin: ' .$origin);
                header('Access-Control-Allow-Headers: origin , Content-Type , Authorization');
            }           
        }
        return $next($request);
    }
}
