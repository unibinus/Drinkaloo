<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function friendIndex()
    {
        $u = new User();
        $userSession = Session('mySession','default');
        $user = $u->where('username','LIKE', $userSession['username'])->first();

        $f = new Friend();
        $friends = $f->where('user_id', 'LIKE', $userSession['id'])->where('status_id', '=', 1)->get();

        //Cek Friends Pending
        $friendsPens = $f->where('user_id', 'LIKE', $userSession['id'])->where('status_id', '=', 2)->get();

        //Cek Friends Incoming
        $incomeFriends = $f->where('friend_id', 'LIKE', $userSession['id'])->where('status_id', '=', 2)->get();

        return view('friend',compact('user', 'friends', 'friendsPens', 'incomeFriends'));
    }

    public function incomingRequest(Request $request){
        $accUID = $request->btnAcc;
        //acc itu id dari user yang dipencet accept
        $rejUID = $request->btnRej;
        //rej itu id dari user yang dipencet Reject
        $userSession = Session('mySession','default');
        $f = new Friend();
        $newList = new Friend();
        //If accept
        if($accUID != null){
            //update
            $f->where('user_id', 'LIKE', intval($accUID))->where('friend_id', 'LIKE',$userSession['id'])->delete();
            $friend = new Friend();
            $friend->status_id = 1;
            $friend->user_id = intval($accUID);
            $friend->friend_id = $userSession['id'];
            $friend->save();

            //biar si friend juga punya hubungan sama si user id sekarang
            $newList->user_id = $userSession['id'];
            $newList->friend_id = $accUID;
            $newList->status_id = 1;
            $newList->save();
        }
        // if reject
        else{
            $f->where('user_id', 'LIKE', $rejUID)->where('status_id', '=', 2)->where('friend_id', 'LIKE', $userSession['id'])->delete();
        }
        return back();
    }

    public function cancelRequest(Request $request){
        $user = $request->cancelReq;
        $u = new User();
        $userSession = Session('mySession','default');

        $f = new Friend();
        $friendsPen = $f->where('user_id', 'LIKE', $userSession['id'])->where('status_id', '=', 2)->where('friend_id', 'LIKE', $user)->delete();

        return back();
    }

    public function addFriend(Request $request)
    {
        $u = new User();
        $userSession = Session('mySession','default');
        //dapetin user yang unamenya ditulis di kotak
        $userSearch = $u->where('username','LIKE', $request->addFriend)->first();

        $friend = new Friend();
        if($userSearch != null){
            //dapetin friends yang di search oleh User (cek apa ada di list dia)
            $friends = $friend->where('user_id', $userSession['id'])->where('friend_id', 'LIKE', $userSearch->id)->get();

            if($userSearch->role_id == 1){
                return back()->withErrors(['Errors' => "Can't add this user"]);
            }
            else{
                if(sizeOf($friends)==0){
                    $friend->user_id = $userSession['id'];
                    $friend->friend_id = $userSearch->id;
                    $friend->status_id = 2;
                    $friend->save();
                    return back()->with('Success', 'Sending friend request');
                }
                else{
                    return back()->withErrors(['Errors' => 'Friends already exists']);
                }
            }
        }
        else{
            return back()->withErrors(['Errors' => 'User does not exist']);
        }
    }
}
