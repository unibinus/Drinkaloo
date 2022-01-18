<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    public function loginIndex()
    {
        return view('login');
    }

    public function registerIndex()
    {
        return view('register');
    }

    public function registerForm(Request $request){
        $validationRules = [
            'username' => 'required|unique:users,username|min:6',
            'fullName' => 'required',
            'password' => 'required|alpha_num|min:6',
            'role' => [
                'required',
                Rule::in(['Admin','Member']),
            ],
        ];

        $errorMsg = [
            'username.required' => 'Username cannot be empty',
            'username.unique' => 'Sorry, the username has been taken',
            'username.min' => 'Username length must be at least 6 characters',
            'fullName.required' => 'Fullname cannot be empty',
            'password.required' => 'Password cannot be empty',
            'password.alpha_num' => 'Password must contains alpha numeric',
            'password.min' => 'Password must be at least 6 characters',
            'role.required' => 'Role cannot be empty',
            'role.in' => 'Role must be either Admin or Member',
        ];

        $validator = Validator::make($request->all(), $validationRules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $user = new User();
        $role = new Role();
        $roleID = $role::where('name','LIKE',$request->role)->first()->id;

        $user->username = $request->username;
        $user->fullName = $request->fullName;
        $user->level = 0;
        $user->role_id = $roleID;
        $user->password =  Hash::make($request->password);
        $user->profilePic = "public/images/pic1.jpg";
        $user->save();

        return redirect('/')->with('Success','Congratulations, Your account has been created successfully!');

    }

    public function loginForm(Request $request){

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $errorMsg = [
            'exists' => 'Invalid User Credentials.'
        ];

        if(Auth::attempt($credentials, true)){
            $user = new User();
            $userAccount = $user::where('username','LIKE',$request->username)->first();
            $attr = $userAccount->getAttributes();

            $request->session()->put('mySession', $attr);

            if($request->rememberMeChkbox){
                Cookie::queue('myCookie', $request->username, 120);
            }
            if($userAccount->role_id == 2){
                $c = new Cart();
                $cart = $c->where('user_id','LIKE',$userAccount->id)->get();
                $cart = json_encode($cart);
                Cookie::queue($userAccount->id."cart",$cart,0);
            }
            return redirect('/');
        }
        return back()->withErrors($errorMsg);
    }

    public function logout(Request $request){
        $user = Session('mySession');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget($user['id'].'cart'));
        return redirect('/');
    }


}
