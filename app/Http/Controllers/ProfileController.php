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
            'myfile.*' => 'mimes:jpg, png|max:100|nullable',
            'newPassword' => 'nullable|alpha_num|min:6',
            'newPassword_Confirmation' => 'same:newPassword',
        ];
        $errorMsg = [
            'fullName.required' => 'Fullname cannot be empty',
            'password.required' => 'Password is required',
            'password.alpha_num' => 'Password must contains alpha numeric',
            'password.min' => 'Password must be at least 6 characters',
            'myfile.mimes' => 'Only acccept .jpg and .png',
            'myfile.max' => 'The maximum size is 100KB',
            'newPassword.alpha_num' => 'New Password must contains alpha numeric',
            'newPassword.min' => 'New Password must be at least 6 characters',
            'newPassword_confirmation.same' => 'Confirm password is not the same as new password',
        ];

        $validator = Validator::make($request->all(), $validationRules, $errorMsg);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        if(!Hash::check($request->password, $user->password)){
            return back()->withErrors("Your Password is incorrect");
        }

        $file = $request->file('myfile');

        $user->fullName = $request->fullName;
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
