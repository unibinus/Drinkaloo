<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    public function headerTransaction(){
        return $this->belongsTo(HeaderTransaction::class, 'header_transaction_id');
    }
    public function game(){
        return $this->belongsTo(Game::class, 'game_id');
    }

    // protected $primaryKey = 'header_transaction_id';
}
