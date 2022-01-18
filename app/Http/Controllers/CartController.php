<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    //
    public function index(){
        $userSession = session('mySession','default');
        $userID = $userSession['id'];
        $cookieCart = Cookie::get($userID.'cart');
        $cart = json_decode($cookieCart);
        $g = new Game();
        $gameIDs =[];
        for ($i=0; $i < sizeof($cart) ; $i++) {
            //ambil id game dari cart
            array_push($gameIDs,$cart[$i]->game_id);
        }
        // query
        $games = $g->whereIn('id',$gameIDs)->get();
        $totalPrice = 0;
        for($i = 0; $i < sizeof($games); $i++) {
            $totalPrice += $games[$i]->price;
        }
        return view('shoppingcart',compact('games','totalPrice'));
    }
    public function deleteItemCart(Request $request){
        $userSession = session('mySession','default');
        $gameID = $request->id;
        $userID = $userSession['id'];
        $c = new Cart();
        $c->where('game_id','LIKE',$gameID)->where('user_id','LIKE',$userID)->delete();
        $arrCarts = $c->where('user_id','LIKE',$userID)->get();
        $newCarts = json_encode($arrCarts);
        Cookie::queue($userID."cart",$newCarts,0);
        return back();
    }
    public function addToCart(Request $request, $id){

        $userSession = session('mySession','default');
        $c = new Cart();
        $gameID = (int) $id;
        $userID = $userSession['id'];
        $gameExistInCart = $c->where('user_id','LIKE',$userID)->where('game_id','LIKE',$gameID)->first();
        if($gameExistInCart){
            return back()->with('Error','This game already in your cart');
        }
        $c->game_id = $gameID;
        $c->user_id = $userID;
        $c->save();
        //create
        //get cookie
        $cartCookie = Cookie::get($userID.'cart');
        //array
        $arrCarts = json_decode($cartCookie);
        //add to cart
        array_push($arrCarts,$c);
        //delete cookie
        Cookie::queue(Cookie::forget($userID.'cart'));
        //encode to json
        $newCarts = json_encode($arrCarts);
        //insert cookie
        Cookie::queue($userID."cart",$newCarts,0);
        return back()->with('Success','This game has been added to your cart');
    }
}
