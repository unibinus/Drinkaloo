<?php
namespace App\Http\Middleware;

use App\Models\Drink;
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
        $d = new Drink();
        $drink = $d->where('id','LIKE',$request->id)->first();
        if($drink == null){
            return redirect('/');
        }
        $validAge = Cookie::get('ValidAge');
        if($drink->adultsOnly && $validAge == null){
            return response()->view('checkage',compact('drink'));
        }
        return $next($request);
    }
}
