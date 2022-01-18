<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    public function friends(){
        return $this->hasMany(Friend::class);
    }
    // public function users(){
    //     return $this->belongsToMany(User::class,'friends','status_id','friend_id');
    // }

}
