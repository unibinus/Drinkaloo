<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profileIndex()
    {
        $u = new User();
        $userSession = Session('mySession','default');
        $user = $u->where('username', 'like', $userSession['username'])->first();

        return view('profile',compact('user'));
    }

    public function updateProfileForm(Request $request){
        $userSession = Session('mySession','default');
        $u = new User();
        $user = $u->where('username','LIKE',$userSession['username'])->first();
        $validationRules = [
            'fullName' => 'required',
            'password' => 'required|alpha_num|min:6',
            // nullable biar kalau misal ga diinput, ga dianggap error
            // validation file kayaknya ga perlu
            'myfile.*' => 'mimes:jpg, png|max:100|nullable',
            'newPassword' => 'nullable|alpha_num|min:6',
            //lebih ez pakai same
            'newPassword_Confirmation' => 'same:newPassword',
        ];
        $errorMsg = [
            'fullName.required' => 'Fullname cannot be empty',
            'password.required' => 'Password is required',
            //pass must be alphanum and min 6
            'password.alpha_num' => 'Password must contains alpha numeric',
            'password.min' => 'Password must be at least 6 characters',
            'myfile.mimes' => 'Only acccept .jpg and .png',
            'myfile.max' => 'The maximum size is 100KB',
            // 'password.password' => 'Wrong Password',
            'newPassword.alpha_num' => 'New Password must contains alpha numeric',
            'newPassword.min' => 'New Password must be at least 6 characters',
            // 'newPassword.confirmed' => 'Confirm password is not the same as new password',
            //if confirmation fail
            'newPassword_confirmation.same' => 'Confirm password is not the same as new password',
        ];

        $validator = Validator::make($request->all(), $validationRules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        //asumsi validasi password di bagian terakhir aja
        if(!Hash::check($request->password, $user->password)){
            return back()->withErrors("Your Password is incorrect");
        }

        $file = $request->file('myfile');

        $user->fullName = $request->fullName;
        //case kalau misal user ga input new password,
        // untuk menghindari "" disave di db
        if($request->newPassword != null){
            $user->password = Hash::make($request->newPassword);
        }

        if($file != null){
            $newImage = time().".".$file->getClientOriginalExtension();
            Storage::putFileAs('public/images', $file, $newImage);
            $newImage = 'public/images/'.$newImage;
            
            Storage::delete('public/'.$user->profilePic);
            $user->profilePic = $newImage;
        }
        else{
            $user->profilePic = $user->profilePic;
        }

        $user->save();
        $attr = $user->getAttributes();
        $request->session()->put('mySession', $attr);

        return back()->with('Success','Congratulations, Your account has been updated successfully!');

    }
}
