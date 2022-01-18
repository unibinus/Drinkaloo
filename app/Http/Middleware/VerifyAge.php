<?php

namespace App\Http\Middleware;

use App\Models\Game;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VerifyAge
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
        $g = new Game();
        $game = $g->where('id','LIKE',$request->id)->first();
        if($game == null){
            return redirect('/');
        }
        $validAge = Cookie::get('ValidAge');
        // dd($validAge);
        if($game->adultsOnly && $validAge == null){
            return response()->view('checkage',compact('game'));
        }
        return $next($request);
    }
}
