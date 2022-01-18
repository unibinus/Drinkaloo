<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;
    // public function cart(){
    //     return $this->hasMany(Cart::class);
    // }
    public function transactionDetail(){
        return $this->hasMany(TransactionDetail::class);
    }
    public function user(){
        return $this->belongsToMany(User::class,'carts','drink_id','user_id');
    }
    public function headerTransactions(){
        return $this->belongsToMany(HeaderTransaction::class,'transaction_details','drink_id','header_transaction_id');
    }

}
