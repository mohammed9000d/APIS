<?php

namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $age)
    {
        //Before middleware
        // $age = 16;0
        // if($age >= 18){
        //     return $next($request);
        // }
        // return abort(403);


    //After middleware
    $response = $next($request);
        // $age = 16;
        if($age < 16){
            return abort(403);
        }
        return $response ;

    }
}
