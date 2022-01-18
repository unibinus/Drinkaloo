<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Drink;
use App\Models\HeaderTransaction;
use App\Models\TransactionDetail;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    public function transactionHistory(Request $request){
        $userSession = Session('mySession','default');
        $ht = new HeaderTransaction();
        $transactions = $ht->where('user_id', 'LIKE', $userSession['id'])->get();

        $filteredTransactions = [];

        //Loop sebanyak transactions yang dimiliki user
        for($i=0; $i<sizeOf($transactions); $i++){
            $detailDrink = $transactions[$i]->drinks;
            $totalPrice = 0;

            //Loop sebanyak drink yang dibeli user dalam 1 transaksi
            for($j=0; $j<sizeOf($detailDrink); $j++){
                $totalPrice += $detailDrink[$j]->price;
            }
            $temp = [
                'transactionID' => $transactions[$i]->id,
                'purchaseDate' => $transactions[$i]->created_at,
                'drinks' =>  $detailDrink,
                'totalPrice' => $totalPrice,
            ];

            array_push($filteredTransactions, $temp);
        }

        return view('transactionHistory', compact('filteredTransactions'));
    }

    public function transactionInformationIndex(){
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
        return view('transactionInformation',compact('totalPrice'));
    }

    public function transactionInformation(Request $request){
        $validationRules = [
            'cardName' => 'required|min:6',
            'cardNumber' => ['required',
                function ($attribute, $value, $fail) {
                    $cardFormat = explode(" ", $value);
                    //formatnya bukan " ", atau kelebihan spasi
                    if (sizeOf($cardFormat) != 4) {
                        $fail("Card Number must be in '0000 0000 0000 0000' format.");
                        return;
                    }
                    //kalau kelebihan angka
                    for($i = 0; $i < 4; $i++){
                        if(strlen($cardFormat[$i]) != 4){
                            $fail("Card Number must be in '0000 0000 0000 0000' format.");
                            return;
                        }
                    }
                    //kalau bukan numeric
                    $cardNumber = str_replace(" ","",$value);
                    // dd($value, $cardFormat, $cardNumber);
                    for($i = 0; $i < strlen($cardNumber); $i++){
                        if(!is_numeric($cardNumber[$i])){
                            $fail("Card Number must be numeric.");
                            return;
                        }
                    }
                },
            ],
            'expiredDateMonth' => 'required|numeric|between:1,12',
            'expiredDateYear' => 'required|numeric|between:2021,2050',
            'cvcNumber' => 'required|digits_between:3,4',
            'country' => 'required',
            'zip' => 'required|numeric',
        ];
        $errorMsg = [
            'cardName.required' => 'Card Name cannot be empty.',
            'cardName.min' => 'Card Name must be at least 6 characters.',
            'expiredDateMonth.required' => 'Card Expired Month cannot be empty.',
            'expiredDateMonth.numeric' => 'Card month must be numeric.',
            'expiredDateMonth.between' => 'Card month must between 1 and 12.',
            'expiredDateYear.required' => 'Card Expired Year cannot be empty.',
            'expiredDateYear.numeric' => 'Card Expired Year must be numeric.',
            'expiredDateYear.between' => 'Card Expired Year must between 2021 and 2050.',
            'cvcNumber.required' => 'Card CVC/CVV Number cannot be empty.',
            'cvcNumber.digits_between' => 'Card CVC/CVV Number must be between 100 and 9999.',
            'country.required' => 'Country must be selected.',
            'zip.required' => 'ZIP cannot be empty.',
            'zip.numeric' => 'ZIP must be numeric.',
        ];

        $validator = Validator::make($request->all(), $validationRules, $errorMsg);

        if($validator->fails()){
            return back()->withErrors($validator);
        }
        //init var
        $userSession = Session('mySession','default');
        $u = new User();
        $c = new Cart();
        $user = $u->where('id','LIKE',$userSession['id'])->first();
        $cookieCart = Cookie::get($user->id.'cart');
        $cart = json_decode($cookieCart);
        if(sizeOf($cart) == 0){
            return back();
        }
        $drinkIDs =[];
        for ($i=0; $i < sizeof($cart) ; $i++) {
            //ambil id drink dari cart
            array_push($drinkIDs,$cart[$i]->drink_id);
        }
        //insert ke transaction
        $ht = new HeaderTransaction();
        $ht->user_id = $user->id;
        $currentDate = new DateTime("now");
        $ht->purchaseDate = $currentDate->format('Y-m-j H:i:s');
        $ht->save();

        for($i = 0; $i < sizeof($cart); $i++){
            $td = new TransactionDetail();
            $td->header_transaction_id = $ht->id;
            $td->drink_id = $cart[$i]->drink_id;
            $td->quantity = $cart[$i]->quantity;
            $td->save();
        }

        // //add level user
        // $user->level += sizeof($cart);
        // $user->save();

        //refresh session
        $attr = $user->getAttributes();
        $request->session()->put('mySession', $attr);

        //clear cart
        $c->where('user_id','LIKE',$user->id)->whereIn('drink_id',$drinkIDs)->delete();
        // dd("DELET",$drinkIDs,$user->id);
        // $cart = [];
        // $newCarts = json_encode($cart);
        // Cookie::queue($user->id."cart",$newCarts,0);
        Session::put('transactionSession', $ht->id);
        return redirect('/TransactionReceipt');
    }
    public function transactionReceiptIndex(Request $request){
        $userSession = Session('mySession','default');
        $transactionID = Session('transactionSession','default');
        $ht = new HeaderTransaction();
        $transactionReceipt = [];
        if($transactionID != 'default'){

            $transactions = $ht->where('user_id', 'LIKE', $userSession['id'])->where('id','LIKE',$transactionID)->first();

            //loop dari transaction sekarang
            $transactionDetails = $transactions->transactionDetail;
            // dd($transactions, sizeOf($transactionDetails),$transactionDetails);
            $totalPrice = 0;
            for($i = 0; $i < sizeOf($transactionDetails); $i++){
                // dd($transactionDetails[$i]->drink, $transactionDetails[$i]->quantity * $transactionDetails[$i]->drink->price);
                $temp = [
                    'drink' => $transactionDetails[$i]->drink,
                    'quantity' => $transactionDetails[$i]->quantity,
                    'subTotal' => $transactionDetails[$i]->quantity * $transactionDetails[$i]->drink->price,
                ];
                $totalPrice += $temp['subTotal'];
                array_push($transactionReceipt,$temp);
            }
            // dd($transactionReceipt);
            $request->session()->forget('transactionSession');
        }
        return view('transactionreceipt',compact('transactions','transactionReceipt','totalPrice'));
    }
}
