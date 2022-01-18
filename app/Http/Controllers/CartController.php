<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Drink;
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
        $g = new Drink();
        $drinkIDs =[];
        for ($i=0; $i < sizeof($cart) ; $i++) {
            //ambil id drink dari cart
            array_push($drinkIDs,$cart[$i]->drink_id);
        }
        // query
        $drinks = $g->whereIn('id',$drinkIDs)->get();
        $totalPrice = 0;
        for($i = 0; $i < sizeof($drinks); $i++) {
            $totalPrice += $drinks[$i]->price;
        }
        return view('shoppingcart',compact('drinks','totalPrice'));
    }
    public function deleteItemCart(Request $request){
        $userSession = session('mySession','default');
        $drinkID = $request->id;
        $userID = $userSession['id'];
        $c = new Cart();
        $c->where('drink_id','LIKE',$drinkID)->where('user_id','LIKE',$userID)->delete();
        $arrCarts = $c->where('user_id','LIKE',$userID)->get();
        $newCarts = json_encode($arrCarts);
        Cookie::queue($userID."cart",$newCarts,0);
        return back();
    }
    public function addToCart(Request $request, $id){

        $userSession = session('mySession','default');
        $c = new Cart();
        $drinkID = (int) $id;
        $userID = $userSession['id'];
        $drinkExistInCart = $c->where('user_id','LIKE',$userID)->where('drink_id','LIKE',$drinkID)->first();
        if($drinkExistInCart){
            return back()->with('Error','This drink already in your cart');
        }
        $c->drink_id = $drinkID;
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
        return back()->with('Success','This drink has been added to your cart');
    }
}
