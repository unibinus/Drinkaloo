<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ValidCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userSession = session('mySession','default');
        $userID = $userSession['id'];
        $cookie = Cookie::get($userID.'cart');
        $arr = json_decode($cookie);
        // dd($arr,$next);
        if(sizeof($arr) > 0){
            return $next($request);
        }
        return redirect('/Cart');
    }
}
