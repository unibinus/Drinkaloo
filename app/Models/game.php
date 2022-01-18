<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    public function cart(){
        return $this->hasMany(Cart::class);
    }
    public function transactionDetail(){
        return $this->hasMany(TransactionDetail::class);
    }
    public function users(){
        return $this->belongsToMany(User::class,'carts','game_id','user_id');
    }
    public function headerTransactions(){
        return $this->belongsToMany(HeaderTransaction::class,'transaction_details','game_id','header_transaction_id');
    }

}
