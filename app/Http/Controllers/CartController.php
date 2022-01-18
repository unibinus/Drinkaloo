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
        $d = new Drink();
        $c = new Cart();
        //get cart
        $cart = $c->where('user_id','LIKE',$userID)->orderBy('drink_id', 'asc')->get();
        $drinks = $d->where('user_id','LIKE',$userID);
        $drinkIDs =[];
        for ($i=0; $i < sizeof($cart) ; $i++) {
            //ambil id drink dari cart
            array_push($drinkIDs,$cart[$i]->drink_id);
        }
        //get drink
        $drinks = $d->whereIn('id',$drinkIDs)->orderBy('id', 'asc')->get();
        /**
         * filter ke array yang isinya atau return 3 macam ini?
         * drink, quantityCart, totalPrice,
         */
        // dd($cart);
        $data = [];
        $totalPrice = 0;
        for($i = 0; $i < sizeOf($drinks); $i++){
            $drink = $drinks[$i];
            $temp = [
                'drink' => $drinks[$i],
                'quantityInCart' => $cart[$i]->quantity,
                'subTotalPrice' =>  $cart[$i]->quantity * $drinks[$i]->price,
            ];
            $totalPrice += $cart[$i]->quantity * $drinks[$i]->price;
            array_push($data,$temp);
        }
        return view('shoppingcart',compact('data', 'totalPrice'));
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
        $d = new Drink();
        $drinkID = (int) $id;
        $userID = $userSession['id'];
        $drinkExistInCart = $c->where('user_id','LIKE',$userID)->where('drink_id','LIKE',$drinkID)->first();
        $drink = $d->where('id','LIKE',$drinkID)->first();
        if($drinkExistInCart){
            $currQuantity = $drinkExistInCart->quantity;

            if($currQuantity++ >= $drink->quantity){
                return back()->with('Error','You have added more than the drink\'s quantity');
            }
            $c->where('user_id','LIKE',$userID)->where('drink_id','LIKE',$drinkID)->delete();
            $newEntryCart = new Cart();
            $newEntryCart->user_id = $drinkExistInCart->user_id;
            $newEntryCart->drink_id = $drinkExistInCart->drink_id;
            $newEntryCart->quantity = $currQuantity;
            // dd($drinkExistInCart,$drinkExistInCart->quantity,$currQuantity,$drink->quantity);

            $newEntryCart->save();
            return back()->with('Success','This drink has been added to your cart');
        }
        $c->drink_id = $drinkID;
        $c->user_id = $userID;
        $c->quantity = 1;
        $c->save();
        return back()->with('Success','This drink has been added to your cart');
    }
}
