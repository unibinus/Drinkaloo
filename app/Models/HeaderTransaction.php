<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderTransaction extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function transactionDetail(){
        return $this->hasMany(TransactionDetail::class);
    }
    public function games(){
        return $this->belongsToMany(Game::class,'transaction_details','header_transaction_id','game_id');
    }
}
