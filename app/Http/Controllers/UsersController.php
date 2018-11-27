<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function avatar() {
        return view('users.avatar');
    }
    public function changeAvatar(Request $request) {
        $file = $request->file('img');
        $filename = md5(time().Auth::user()->id).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('avatars'),$filename);
        Auth::user()->avatar = '/avatars/'.$filename;
        Auth::user()->save();
        return ['url' => Auth::user()->avatar];
    }
}











