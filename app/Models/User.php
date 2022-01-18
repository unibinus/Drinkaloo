<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;
    // public function cart(){
    //     return $this->hasMany(Cart::class);
    // }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function friend(){
        return $this->hasMany(Friend::class);
    }
    public function headerTransaction(){
        return $this->hasMany(HeaderTransaction::class);
    }
    public function games(){
        return $this->belongsToMany(Game::class,'carts','user_id','game_id');
    }
    // public function friends(){
    //     return $this->belongsToMany(Status::class,'friends','user_id','status_id');
    // }

    // public function setPasswordAttribute($password){
    //     $this->attributes['password'] = Hash::make($password);
    // }
}
